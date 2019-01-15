<?php
/**
 * Created by PhpStorm.
 * User: cbellotti
 * Date: 19/04/17
 * Time: 15:29
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Product;
use AppBundle\Entity\Purchase;
use AppBundle\Entity\PurchaseDetail;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class ShopController
 * @package AppBundle\Controller
 * @Route("/shop", name="shop")
 */
class ShopController extends Controller {

    /**
     * @Route("/", name="shoplist")
     */
    public function listShop(){
        $user = $this->getUser();
        if(isset($user)) {
            $em = $this->getDoctrine();
            $productTable = $em->getRepository("AppBundle:Product");
            $products = $productTable->findBy(array('isAvailable' => '1'), array('id' => 'desc'), 20);
            return $this->render("@App/shop/shop.html.twig", [
                'products' => $products,
            ]);
        }
        return $this->redirectToRoute('fos_user_security_login');

    }

    /**
     * @Route("/{id}", requirements={"id" = "\d+"}, name="productdetail")
     */
    public function detailProduct($id){
        $user = $this->getUser();
        if(isset($user)) {
            $em = $this->getDoctrine();
            $productTable = $em->getRepository("AppBundle:Product");
            $product = $productTable->find($id);
            if(isset($product)){
                return $this->render("@App/shop/product.html.twig",[
                    'product' => $product,
                    'productname' => $product->getName(),
                ]);
            }
            else{
                $product = null;
                return $this->render("@App/shop/product.html.twig",[
                    'productname' => "Produit inexistant ou indisponible",
                    'product' => $product,
                ]);
            }
        }
        return $this->redirectToRoute('fos_user_security_login');
    }

    /**
     * @Route("/newproduct", name="newproduct")
     */
    public function createProduct(Request $request){
        if($request->getMethod() == 'GET'){
            if($this->getUser()){
                return $this->render("@App/shop/createproduct.html.twig");
            }
            return $this->redirectToRoute("fos_user_security_login");
        }
        $em = $this->getDoctrine()->getManager();
        $product = new Product();
        $product->setPrice($_POST['price']);
        $product->setIsAvailable(true);
        $product->setDescription($_POST['description']);
        $product->setName($_POST['name']);
        $em->persist($product);
        $em->flush();
        return $this->redirectToRoute("shoplist");
    }

    /**
     * @Route("/buy", name="buy")
     */
    public function buy(Request $request){
        $user = $this->getUser();
        if(isset($user)){

            $em = $this->getDoctrine()->getManager();
            $purchaseTable = $em->getRepository("AppBundle:Purchase");
            $orders = $purchaseTable->findBy(array('user'=>$user));
            if(isset($orders)){
                foreach ($orders as $order){
                    if($order->getIsCurrent()){
                        $currentOrder = $order;
                    }
                }
            }

            if(!isset($currentOrder)){
                $currentOrder = new Purchase();
                $currentOrder->setIsCurrent(true);
                $currentOrder->setUser($user);
                $currentOrder->setDate(new \DateTime());
            }
            if($request->getMethod()=='POST'){
                $productTable = $em->getRepository("AppBundle:Product");
                $orderdetail = new PurchaseDetail();
                $product = $productTable->find($_POST['productid']);
                $orderdetail->setProduct($product);
                $orderdetail->setQuantity($_POST['quantity']);
                $orderdetail->setUnitPrice($product->getPrice());
                $orderdetail->setPurchase($currentOrder);
                $currentOrder->addPurchaseDetail($orderdetail);
                $total = 0;
                foreach ($currentOrder->getPurchaseDetails() as $purchaseDetail){
                    $total += $purchaseDetail->getUnitPrice() * $purchaseDetail->getQuantity();
                }
                $currentOrder->setAmount($total);
                $em->persist($orderdetail);
                $em->persist($currentOrder);
                $em->flush();
            }

            return $this->render("@App/user/cart.html.twig",[
                'order' => $currentOrder,
            ]);
        }
        return $this->redirectToRoute('fos_user_security_login');
    }
}
