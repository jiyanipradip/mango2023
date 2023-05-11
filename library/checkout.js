function setPaymentInfo(isChecked)
{
	with (window.document.frmCheckout) {
		if (isChecked) {
			txtPaymentFirstName.value  = txtShippingFirstName.value;
			txtPaymentLastName.value   = txtShippingLastName.value;
			
			
			
			
			// updated
			
			txtPaymentmName.value     		= txtShippingmName.value;
			txtpaymentsuffix.value    		= txtShippingsuffix.value;
			
			txtPaymentAddress1.value  		= txtShippingAddress1.value;
			txtPaymentAddress2.value  		= txtShippingAddress2.value;
			txtPaymentCity.value      		= txtShippingCity.value;
			txtPaymentState.value     		= txtShippingState.value;			
			txtPaymentPostalCode.value 		= txtShippingPostalCode.value;
			txtPaymentcountry.value   		= txtShippingcountry.value;
			txtpaymentphone.value      		= txtShippingphone.value;
			
			
			
			txtPaymentphoneext.value   		= txtShippingphoneExten.value;
			txtPaymentcellphone.value   	= txtShippingcellphone.value;
			txtPaymentemail.value   		= txtShippingemail.value;
			txtPaymentcompName.value 		= txtShippingcomp.value;
			txtPaymentfax.value 		    = txtShippingefax.value;

			
			
			
			// updated
			
			
			
			
			txtPaymentFirstName.readOnly  = true;
			txtPaymentLastName.readOnly   = true;
			txtPaymentAddress1.readOnly   = true;
			txtPaymentAddress2.readOnly   = true;
			txtpaymentphone.readOnly      = true;
			txtPaymentState.readOnly      = true;			
			txtPaymentCity.readOnly       = true;
			txtPaymentPostalCode.readOnly = true;			
			txtPaymentmName.readOnly      = true;
			txtpaymentsuffix.readOnly     = true;
			
			txtPaymentAddress1.readOnly   = true;
			txtPaymentAddress2.readOnly   = true;
			txtPaymentCity.readOnly       = true;
			txtPaymentState.readOnly      = true;
			txtPaymentState.readOnly      = true;
			txtPaymentPostalCode.readOnly = true;
			txtPaymentcountry.readOnly    = true;
			txtpaymentphone.readOnly      = true;
			txtPaymentphoneext.readOnly   = true;
			txtPaymentcellphone.readOnly  = true;
			txtPaymentemail.readOnly      = true;
			txtPaymentcompName.readOnly   = true;
			txtPaymentfax.readOnly        = true;
			
			
			
		} else {
			txtPaymentFirstName.readOnly  = false;
			txtPaymentLastName.readOnly   = false;
			txtPaymentAddress1.readOnly   = false;
			txtPaymentAddress2.readOnly   = false;
			txtpaymentphone.readOnly      = false;
			txtPaymentState.readOnly      = false;			
			txtPaymentCity.readOnly       = false;
			txtPaymentPostalCode.readOnly = false;			
		}
	}
}


function checkShippingAndPaymentInfo()
{
	with (window.document.frmCheckout) {
		if (isEmpty(txtShippingFirstName, 'Enter first name')) {
			return false;
		} else if (isEmpty(txtShippingLastName, 'Enter last name')) {
			return false;
		} 
		
		
		
		
		else if (isEmpty(txtShippingAddress1, 'Enter shipping address')) {
			return false;
		} 
		
		
		
		else if (isEmpty(txtShippingState, 'Enter shipping address state')) {
			return false;
		} 
		 else if (isEmpty(txtShippingPostalCode, 'Enter the shipping address postal/zip code')) {
			return false;
		}	
		 else if (isEmpty(txtShippingcountry, 'Enter Your country name')) {
			return false;
		}
		 else if (isEmpty(txtShippingphone, 'Enter Phone Number ')) {
			return false;
		}		
		
		
		else if (isEmpty(txtPaymentFirstName, 'Enter first name')) {
			return false;
		} else if (isEmpty(txtPaymentLastName, 'Enter last name')) {
			return false;
		}		
		
				
					
		else if (isEmpty(txtPaymentAddress1, 'Enter Payment address')) {
			return false;
		}		
			
		else if (isEmpty(txtPaymentCity, 'Enter City Name')) {
			return false;
		}
		else if (isEmpty(txtPaymentState, 'Enter Payment address state')) {
			return false;
		}
		else if (isEmpty(txtPaymentPostalCode, 'Enter the Payment address postal/zip code')) {
			return false;
		} 
		else if (isEmpty(txtPaymentcountry, 'Enter Your Country Name')) {
			return false;
		} 
		
		else if (isEmpty(txtpaymentphone, 'Enter Your Phone Num')) {
			return false;
		} 
		 
		
		else if (isEmpty(txtccnum, 'Enter Credit card num')) {
			return false;
		}
		else if (isEmpty(txtccname, 'Enter Credit card Name')) {
			return false;
		}
		else if (isEmpty(txtccexpiredate, 'Enter Credit card Expire Date')) {
			return false;
		}
		else if (isEmpty(txtccv2value, 'Enter Credit card Value')) {
			return false;
		}
		
		 
		else {
			return true;
		}
	}
}
