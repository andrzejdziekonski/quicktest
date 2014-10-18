<?php

namespace Boostit\WebBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Boostit\WebBundle\Entity\ProductLogger;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DefaultController extends Controller
{
    
    /**
     * @Route("/", name="homepage")
     * @Template("BoostitWebBundle:Default:index.html.twig")
     */
    public function indexAction(Request $request)
    {        
        $response = new Response();
        $em = $this->getDoctrine()->getManager();
        $normalizer = new GetSetMethodNormalizer();        
        $encoder = new JsonEncoder();
        $serializer = new Serializer(array($normalizer), array($encoder));
        $productsRepo = $em->getRepository('BoostitWebBundle:Product');       
        $cartProducts = array();
        $products = $productsRepo->findAll();        
        $form = $this->createFormBuilder()
                ->add('products', 'choice', array(
                    'label' => false,
                    'expanded' => true,
                    'choices' => $this->getProductsChoice($products),
                    'attr' => array('class' => 'horizontal')
                ))
                ->getForm(); 
        
        $cookies = $request->cookies;
        if ($cookies->has('cartProducts'))
        {
            $cartCookie = $cookies->get('cartProducts');
            $cartProducts = json_decode($cartCookie,true);
        }
        
        if($request->isMethod('POST')){
            $form->bind($request);
            if($form->isValid()){
                $selected = $form['products']->getData();
                    $selectedProduct = $productsRepo->find($selected);
                    array_push($cartProducts,$selectedProduct);
                    $cookie = new Cookie('cartProducts', $serializer->serialize($cartProducts, 'json'));
                    $response->headers->setCookie($cookie);
                    $log = new ProductLogger();
                    $log->setProduct($selectedProduct);
                    $log->setIp($request->getClientIp());
                    $em->persist($log);
                    $em->flush();
            }
        }
        return $this->render('BoostitWebBundle:Default:index.html.twig', array(
            'form' => $form->createView(),
            'products' => $products,
            'cartProducts' => $cartProducts
        ), $response);
    }
    
    /**
     * @Route("/clear-cookie", name="clear_cookie")     
     */
    public function clearCookieAction(Request $request)
    {
        $response = new RedirectResponse($this->generateUrl('homepage'));
        $response->headers->clearCookie('cartProducts');
        return $response;
    }
            
    private function getProductsChoice($products){
        $array = Array();
        foreach($products as $product){
            $array[$product->getId()] = $product->getName();
        }
        return $array;
    }
}
