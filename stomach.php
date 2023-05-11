<?php  
													if ($pdId)
													{
													require_once 'include/productDetail.php';
													}
 													else if ($catId)
													{
													require_once 'include/productList.php';	
													}
													else if ($scatId)
													{
													require_once 'include/subcategorylist.php';	
													}
													else if ($cart)
													{
													require_once 'cart.php';	
													}
													else if ($cartlist1)
													{
													require_once 'listcart.php';
													}
													else if ($location)
													{
													require_once 'customer/list1.php';	
													}
													else if ($shoppinglist)
													{
													require_once 'shoppinglist.php';	
													}
													else if ($contract)
													{
													require_once 'contract.php';		
													}
													else if ($modifycustomer)
													{
													require_once 'modifycustomer.php';	
													}
													else if ($viewaccounts)
													{
													require_once 'viewaccounts.php';	
													}
													else if ($viewreports)
													{
													require_once 'reports.php';
													}
													else if ($quickorder)
													{
													require_once 'quickorder.php';
													}
													else if ($step)
													{
													require_once 'checkout.php';
													} 
 													else if($fl)
													{
													require_once 'include/productList.php';	
													}
													else if($aboutus)
													{
													require_once 'include/AboutUs.php';	
													}
													else if($terms)
													{
													require_once 'include/terms.php';	
													}
													else if($ship)
													{
													require_once 'include/ship.php';	
													}
													else if($action)
													{
													require_once 'cart.php';	
													}
													else if($success)
													{
													require_once 'success.php';	
													}													
													else
													{														
													require_once 'include/Home.php';	
													}
													?>