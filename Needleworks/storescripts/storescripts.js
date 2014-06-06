//This file contains our javascript functions which are called on different pages in order to validate user input

function validateCheckoutForm()
		{
		    var isValid=true;
			var reg1=/^[A-Za-z ]+$/;
			var reg2=/^[0-9]+$/;
			var reg3=/^[0-9 ]+$/;
			var reg4=/^[A-Za-z0-9 ]+$/;
			var reg5=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
			if(document.checkoutForm.first_name.value=="")
			{
			    alert("Please fill in all fields marked with an asterisk.");
				isValid=false;
			} else if (document.checkoutForm.first_name.value.match(reg1)==null)
			{
			    alert("Please type a valid first name. Only letters or space permitted.");
				isValid=false;
			} else if (document.checkoutForm.surname.value=="")
			{
			    alert("Please fill in all fields marked with an asterisk.");
				isValid=false;
			} else if (document.checkoutForm.surname.value.match(reg1)==null)
			{
			    alert("Please type a valid surname. Only letters or space permitted.");
				isValid=false;
			} else if (document.checkoutForm.card_type.value=="")
			{
			    alert("Please fill in all fields marked with an asterisk.");
				isValid=false;
			} else if (document.checkoutForm.card_number.value=="")
			{
			    alert("Please fill in all fields marked with an asterisk.");
				isValid=false;
			} else if (document.checkoutForm.card_number.value.match(reg3)==null)
			{
			    alert("Please enter a valid credit card number. Only digits or space permitted.");
				isValid=false;
			}else if (document.checkoutForm.expires_month.value=="")
			{
			    alert("Please fill in all fields marked with an asterisk.");
				isValid=false;
			} else if (document.checkoutForm.expires_year.value=="")
			{
			    alert("Please fill in all fields marked with an asterisk.");
				isValid=false;
			} else if (document.checkoutForm.card_address.value=="")
			{
			    alert("Please fill in all fields marked with an asterisk.");
				isValid=false;
			} else if (document.checkoutForm.card_address.value.match(reg4)==null)
			{
			    alert("Please enter a valid address. Only letters, digits or space permitted.");
				isValid=false;
			} else if (document.checkoutForm.card_city.value=="")
			{
			    alert("Please fill in all fields marked with an asterisk.");
				isValid=false;
			} else if (document.checkoutForm.card_city.value.match(reg1)==null)
			{
			    alert("Please enter a valid city. Only letters or space permitted");
				isValid=false;
			} else if (document.checkoutForm.card_country.value=="")
			{
			   alert("Please fill in all fields marked with an asterisk.");
				isValid=false;
			} else if (document.checkoutForm.card_email.value=="")
			{
			    alert("Please fill in all fields marked with an asterisk.");
				isValid=false;
			} else if (document.checkoutForm.card_email.value.match(reg5)==null)
			{
			    alert("Please enter a valid email address");
				isValid=false;
			} 
			return isValid;
		}
		
function validateRegisterForm()
		{
		    var isValid=true;
			var reg1=/^[A-Za-z0-9_-]{1,16}$/;
			var reg3=/^.{1,19}$/;
			if(document.registerForm.username.value=="")
			{
			    alert("Please fill in all fields marked with an asterisk.");
				isValid=false;
			} else if (document.registerForm.username.value.match(reg1)==null)
			{
			    alert("Please type a valid username. Only letters, numbers, hyphens or underscore permitted. The maximum length is 16 characters.");
				isValid=false;
			} else if (document.registerForm.password.value=="")
			{
			    alert("Please fill in all fields marked with an asterisk.");
				isValid=false;
			} else if (document.registerForm.password.value.match(reg3)==null)
			{
			    alert("Please type a valid password. The maximum length is 19 characters.");
				isValid=false;
			} else if (document.registerForm.password.value != document.registerForm.password_again.value)
			{
			    alert("Passwords do not match.");
				isValid=false;
			} 
			return isValid;
		}

function validateMyShipping()
		{
		    var isValid=true;
			var reg1=/^[A-Za-z0-9 ]+$/;
			var reg2=/^[A-Za-z ]+$/;
			if(document.shippingForm.shipping_address.value=="")
			{
			    alert("Please fill in all fields marked with an asterisk.");
				isValid=false;
			} else if (document.shippingForm.shipping_address.value.match(reg1)==null)
			{
			    alert("Please enter a valid address. Only letters, digits or space permitted.");
				isValid=false;
			} else if (document.shippingForm.shipping_city.value=="")
			{
			    alert("Please fill in all fields marked with an asterisk.");
				isValid=false;
			} else if (document.shippingForm.shipping_city.value.match(reg2)==null)
			{
			    alert("Please enter a valid city. Only letters or space permitted");
				isValid=false;
			} else if (document.shippingForm.shipping_country.value=="")
			{
			    alert("Please fill in all fields marked with an asterisk.");
				isValid=false;
			} 
			return isValid;
		}	

function validateMyForm()
		{
		    var isValid=true;
			var reg1=/^[A-Za-z0-9_]+$/;
			var reg2=/^[0-9]+$/;
			if(document.myForm.product_name.value=="")
			{
			    alert("Please type your name.");
				isValid=false;
			} else if (document.myForm.product_name.value.match(reg1)== null)
			{
			    alert("Please type a valid name. Only letters, numbers or underscore permitted.");
				isValid=false;
			} else if (document.myForm.price.value=="")
			{
			    alert("Please type the product price.");
				isValid=false;
			} else if (document.myForm.price.value.match(reg2)== null)
			{
			    alert("Please type a valid product price. The entered value must only contain numerical digits.");
				isValid=false;
			} else if (document.myForm.category.value=="")
			{
			    alert("Please enter the product category.");
				isValid=false;
			} else if (document.myForm.details.value=="")
			{
			    alert("Please type the details of the product.");
				isValid=false;
			} else if (document.myForm.stock.value=="")
			{
			    alert("Please type the number of stock of the product.");
				isValid=false;
			} 
			return isValid;
		}

function validateListForm()
		{
		    var isValid=true;
			var reg1=/^[A-Za-z0-9_.() ]+$/;
			var reg2=/^[0-9]+$/;
			if(document.listForm.product_name.value=="")
			{
			    alert("Please type the product name.");
				isValid=false;
			} else if (document.listForm.product_name.value.match(reg1)== null)
			{
			    alert("Please type a valid name. Only letters, numbers, full stops, spaces, parentheses or underscore permitted.");
				isValid=false;
			} else if (document.listForm.price.value=="")
			{
			    alert("Please type the product price.");
				isValid=false;
			} else if (document.listForm.price.value.match(reg2)== null)
			{
			    alert("Please type a valid product price. The entered value must only contain numerical digits.");
				isValid=false;
			} else if (document.listForm.category.value=="")
			{
			    alert("Please enter the product category.");
				isValid=false;
			} else if (document.listForm.details.value=="")
			{
			    alert("Please type the details of the product.");
				isValid=false;
			} else if (document.listForm.stock.value=="")
			{
			    alert("Please type the number of stock of the product.");
				isValid=false;
			} 
			return isValid;
		}		