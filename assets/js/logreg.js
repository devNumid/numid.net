/* GLOBALES */
document.onreadystatechange = function(e){
	switch (document.readyState) {
		case "loading":					
		case "interactive":	
			showWaiting();		
			break;
		case "complete":
			hideWaiting();
			break;
	}
};
(function() {
	'use strict';
	window.addEventListener('load', function() {
		var forms = document.getElementsByClassName('needs-validation');
		var validation = Array.prototype.filter.call(forms, function(form) {
			form.addEventListener('submit', function(event) {
				event.preventDefault();
				if (validateForm(form) === false) {
					event.stopPropagation();
				}else{
					PostRequest(form, form.dataset.selector);
				}
			}, false);
		});
	}, false);
})();
function validateForm(_form){
	var bool = true;
	var index = _form.elements.length;
	for (let i = 0; i < index; i++) {
		if (((_form.elements[i].type == "text")||(_form.elements[i].type == "number")||(_form.elements[i].type == "textarea")||(_form.elements[i].type == "email")||(_form.elements[i].type == "password")||(_form.elements[i].type == "checkbox")||(_form.elements[i].type == "select-one"))&&(_form.elements[i].dataset.selector == "serialize")){
			if (!validate(_form.id, _form.elements[i].name)&&!_form.elements[i].hidden) { bool = false; }
		}
	}
	return bool;
}
function validate(_id, _index) {
	switch (_id){
		case "frm-openwallet":
		case "frm-createwallet":
			switch (_index){
				case "passphrase":
				case "cpassphrase":
					$("#txtpwd").html("Please fill out this field with at minimum 10 characters.");
					$("#txtcpwd").html("Please fill out this field with at minimum 10 characters.");
					return validateItem({id:_id, index:_index, length:10}, "length");
					break;
				case "compare_password":
					$("#txtpwd").html("The two passphrases are not equal.");
					$("#txtcpwd").html("The two passphrases are not equal.");
					return validateItem({id:_id, index0:"passphrase", index1:"cpassphrase", index:_index, length:10}, "compare_password");
					break;
				case "mnemonic":
					return validateItem({id:_id, index:_index}, "mnemonic");
					break;
				case "mnemonic_confirmation":
					return validateItem({id:_id, index:_index}, "checkbox");
					break;
				default :
					return false;
			}
			break;

		case "frm-delegatewallet":
		case "frm-undelegatewallet":
			switch (_index){
				case "passphrase":
					return validateItem({id:_id, index:_index, length:10}, "length");
					break;
				case "pool":
					return true;
					break;
				default:
					return false;
			}
			break;

		case "frm-getaffiliationrewards":
		case "frm-getwithdrawfee":
		case "frm-addwallet":
		case "frm-withdraw":
			switch (_index){
				case "account":
				case "wallet-account":
					return validateItem({id:_id, index:_index, length:103}, "length");
					break;
				case "amount":
					if(_isMax){
						return true;
					}else{
						return validateItem({id:_id, index:_index, value:1}, "value");
					}
					break;
				case "wallet-name":
					return validateItem({id:_id, index:_index, length:1}, "length");
					break;
				case "passphrase":
					return validateItem({id:_id, index:_index, length:10}, "length");
					break;
				default :
					return false;
			}
			break;

		case "frm-contact":
			switch (_index){
				case "email":
					return validateItem({id:_id, index:_index}, "email");
					break;
				case "message":
					return validateItem({id:_id, index:_index, length:1}, "length");
					break;
				default :
					return false;
			}
			break;
	}
}
function validateItem(_object, _selector){
	var _regex, _item0, _item1;
	switch (_selector){
		case 'email':
			_regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			_item0 = $('#'+_object.id+' *[name='+_object.index+']');
			if (_regex.test(String(_item0.val()).toLowerCase())){
				_item0.addClass("is-valid").removeClass("is-invalid");
				return true;
			}else{
				_item0.addClass("is-invalid").removeClass("is-valid");
				return false;
			}
			break;
		case 'checkbox':
			_item0 = $('#'+_object.id+' *[name='+_object.index+']');
			if (_item0.prop('checked')){
				_item0.addClass("is-valid").removeClass("is-invalid");
				return true;
			}else{
				_item0.addClass("is-invalid").removeClass("is-valid");
				return false;
			}
			break;
		case "length":
			_item0 = $('#'+_object.id+' *[name='+_object.index+']');
			if(_item0.val().length >= _object.length){
				_item0.addClass("is-valid").removeClass("is-invalid");
				return true;
			}else{
				_item0.addClass("is-invalid").removeClass("is-valid");
				return false;
			}
			break;
		case "value":
			_item0 = $('#'+_object.id+' *[name='+_object.index+']');
			if(_item0.val() >= _object.value){
				_item0.addClass("is-valid").removeClass("is-invalid");
				return true;
			}else{
				_item0.addClass("is-invalid").removeClass("is-valid");
				return false;
			}
			break;
		case "compare_password":
			_item0 = $('#'+_object.id+' *[name='+_object.index0+']');
			_item1 = $('#'+_object.id+' *[name='+_object.index1+']');
			if((_item0.val().length >= 1)&&(_item1.val().length >= 1)){
				if(_item0.val() == _item1.val()){
					_item1.addClass("is-valid").removeClass("is-invalid");
					_item0.addClass("is-valid").removeClass("is-invalid");
					return true;
				}else{
					_item1.addClass("is-invalid").removeClass("is-valid");
					_item0.addClass("is-invalid").removeClass("is-valid");
					return false;
				}
			}
			break;
		case "mnemonic" :
			_item0 = $('#'+_object.id+' *[name='+_object.index+']');
			var _words = _item0.val().split(" ");
			var _bool = true;
			_words.every(function(element, index) {
				if (element.length < 1){
					_bool=false;
					return false;
				}else{
					return true;
				}
			});
			if((_words.length >= 15)&&(_words.length <= 24)&&(_bool)){
				_item0.addClass("is-valid").removeClass("is-invalid");
				return true;
			}else{
				_item0.addClass("is-invalid").removeClass("is-valid");
					return false;
			}
			break;
	}
}
$(document).on('change','[name]',function(){
	var _formId = $(this).parents("form").attr("id");
	switch (_formId){
		case 'frm-createwallet':
			validate(_formId, "compare_password");
		case 'frm-openwallet':
		case "frm-delegatewallet":
		case "frm-undelegatewallet":
			validate(_formId, this.name);
			break;
	}
});
function serializeFormJSON(_form){
	var jsonString = '{';
	var index = _form.elements.length;
	for (let i = 0; i < index; i++) {
		if (((_form.elements[i].type == "text")||(_form.elements[i].type == "number")||(_form.elements[i].type == "textarea")||(_form.elements[i].type == "email")||(_form.elements[i].type == "password")||(_form.elements[i].type == "checkbox")||(_form.elements[i].type == "select-one"))&&(_form.elements[i].dataset.selector == "serialize")){
			if (jsonString != '{') jsonString = jsonString.concat(',');
			jsonString = jsonString.concat('"'+_form.elements[i].name+'":"'+_form.elements[i].value+'"');
		}
	}
	jsonString = jsonString.concat('}');
	return jsonString;
}
function ClearInput(_form){
	var index = _form.elements.length;
	for (let i = 0; i < index; i++) {
		if (((_form.elements[i].type == "text")||(_form.elements[i].type == "number")||(_form.elements[i].type == "textarea")||(_form.elements[i].type == "email")||(_form.elements[i].type == "password")||(_form.elements[i].type == "select-one"))&&(_form.elements[i].dataset.selector == "serialize")){
			_form.elements[i].value = "";
			_form.elements[i].className = "form-control";
			$("#"+_form.elements[i].name).removeClass("is-valid").removeClass("is-invalid");
		}else if ((_form.elements[i].type == "checkbox")&&(_form.elements[i].dataset.selector == "serialize")){
			_form.elements[i].checked = false;
			_form.elements[i].className = "form-check-input";
			$("#"+_form.elements[i].name).removeClass("is-valid").removeClass("is-invalid");
		}
	}
}
function UpdateUI(_form, _object, _selector){
	privateUI(_form, _object);
	switch (_selector){
		case "label":
			$('#'+_form.id+' *[name=alert-info]').html('');
			$('#'+_form.id+' *[name=alert-info]').removeClass("alert alert-warning alert-danger alert-info");
			switch (_object.code){
				case "redirect":
					window.location.replace(_object.url);
					break;
				case "success" :
					$('#'+_form.id+' *[name=alert-info]').addClass("alert alert-info");
					$('#'+_form.id+' *[name=alert-info]').html('<strong>Info!</strong> '+_object.message);
					break;
				case "warning" :
					$('#'+_form.id+' *[name=alert-info]').addClass("alert alert-warning");
					$('#'+_form.id+' *[name=alert-info]').html('<strong>Warning!</strong> '+_object.message);
					break;
				case "error" :
					$('#'+_form.id+' *[name=alert-info]').addClass("alert alert-danger");
					$('#'+_form.id+' *[name=alert-info]').html('<strong>Error!</strong> '+_object.message);
					break;
			}
			break;
		case "modal":
			switch (_object.code) {
				case "redirect":
					window.location.replace(_object.url);
					break;
				case "success" :
					$("#xTitre").css('color','#0275B8');
					$("#xTitre").html(_object.code);
					$("#xMessage").html(_object.message);
					$("#alert-message").modal("show");
					break;
				case "warning" :
					$("#xTitre").css('color','#F0AD4E');
					$("#xTitre").html(_object.code);
					$("#xMessage").html(_object.message);
					$("#alert-message").modal("show");
					break;
				case "error" :
					$("#xTitre").css('color','#D9534F');
					$("#xTitre").html(_object.code);
					$("#xMessage").html(_object.message);
					$("#alert-message").modal("show");
					break;
			}
			break;
	}
}
function privateUI(_form, _object){
	switch (_form.id){
		case 'frm-openwallet':
			break;
		case 'frm-createwallet':
			if (_object.code == "success"){
				$('#g-section').removeClass('showdiv').addClass('hidediv');
				$('#m-section').removeClass('showdiv').addClass('hidediv');
			}
			break;

		case "frm-delegatewallet":
		case "frm-undelegatewallet":
			ClearInput(_form);
			switch (_object.code){
				case "delegationfee":
					ClearInput(_form);
					$("#delegatation-fee").val(_object.data);
					$("#delegatation-pool").val($("#PoolId").val());
					$('#delegate-wallet').modal('show');
					break;
				case "delegated":
					ClearInput(_form);
					$("#delg_delegate_area").html('');
					$("#delg_message_area").html('<span>Your wallet is delegated</span>');
					$('#delegate-wallet').modal('hide');
					break;
				case "undelegated":
					ClearInput(_form);
					$("#delg_delegate_area").html('<form id="frm-getdelegatefee" data-url="app/getdelegatefee" data-method="post" class="needs-validation" data-selector="modal" novalidate><button class="btn btn-falcon-warning btn-sm mr-1 mb-1" type="submit"><i class="fas fa-sign-in-alt"></i> Delegate</button></form>');
					$("#delg_message_area").html('<span>Your wallet is not delegated</span>');
					$('#undelegate-wallet').modal('hide');
					break;
			}
			break;

		case "frm-getwithdrawfee":
			ClearInput(_form);
			if (_object.code == "showfee"){
				$('#frm-withdraw *[name=amount]').val(_object.amount);
				$('#frm-withdraw *[name=account]').val(_object.account);
				$('#frm-withdraw *[name=fee]').val(_object.fee);
				$("#send-withdraw").modal("show");
			}
			break;
		case "frm-addwallet":
			ClearInput(_form);
			$('#wallet-list').html(_object.wallet);
			break;
		case "frm-withdraw":
			ClearInput(_form);
			$("#send-withdraw").modal("hide");
			break;

		case "frm-contact":
			ClearInput(_form);
			break;
	}
}
function showWaiting(){
	$("#loading-indicator").removeClass("hidediv");
	$("#loading-indicator").addClass("showdiv");
}
function hideWaiting(){
	$("#loading-indicator").removeClass("showdiv");
	$("#loading-indicator").addClass("hidediv");
}
/* WALLET */
function showNext(){
	if (validate('frm-createwallet','mnemonic_confirmation')){
		$('#g-section').removeClass('showdiv').addClass('hidediv');
		$('#m-section').removeClass('hidediv').addClass('showdiv');
	}
}
function showOpenWallet(){
	$('#open-wallet').removeClass('hidediv').addClass('showdiv');
	$('#create-wallet').removeClass('showdiv').addClass('hidediv');
}
function showCreatWallet(){
	GetRequest();
}
/* WITHDRAW */
var _isMax = false;
function UpdateWallet(_id){	$("#account").val(_id); }
function SetMaxWithdraw(){
	if (_isMax){
		_isMax = false;
		$('#amount').prop("disabled",false);
	}else{
		_isMax = true;
		$('#amount').prop("disabled",true);
	}
}
$('#send-withdraw').on('hidden.bs.modal', function () {
	_isMax = false;
	$('#amount').prop("disabled",false);
	$("#frm-withdraw").each(function(){
		ClearInput(this);
	});
});
/* HTTP */
function PostRequest(_form, _selector) {
	var _err = false;	
	var _req = {
			method: _form.dataset.method,
			headers: {
				'Accept': 'application/json',
				'Content-Type': 'application/json'
				},
			body: serializeFormJSON(_form)
		};		
	showWaiting();
	fetch(_form.dataset.url, _req)
	.then(response => {
		hideWaiting();		
		if (response.ok) {
			return response.text();
		} else {
			_err =true;			
		}
	})
	.then(data => {
		if (!_err){
			try {
				UpdateUI(_form, JSON.parse(data), _selector);
			} catch(err) {				
				UpdateUI(_form, {code: "warning", message: response.status+" "+response.statusText}, _selector);
			}
		}else{			
			UpdateUI(_form, {code: "error", message: error}, _selector);
		}
	})
	.catch(function(error) {		
		UpdateUI(_form, {code: "error", message: error}, _selector);
	});
}
function GetRequest() {
	var _err = false;
	showWaiting();
	fetch("createwallet/genmnemonic")
	.then(response => {
		hideWaiting();
		if (response.ok) {
			return response.text();
		}else{
			_err = true;			
		}
	})
	.then(data => {
		if (!_err){
			try {
				var _object = JSON.parse(data);
				var lg = _object.mnemonic.length;
				var mnemonic = "";
				for (i=0;i<lg;i++){
					if (mnemonic != "") mnemonic = mnemonic + " ";
					mnemonic = mnemonic + _object.mnemonic[i];
				}
				$('#mnemonic').val(mnemonic);
				$('#mnemonic').addClass("is-valid").removeClass("is-invalid");
				$('#open-wallet').removeClass('showdiv').addClass('hidediv');
				$('#create-wallet').removeClass('hidediv').addClass('showdiv');
			} catch(err) {				
				$('#mnemonic').val("an error has occurred, unable create mnemonic words.");
				$('#mnemonic').addClass("is-invalid").removeClass("is-valid");
			}
		}else{			
			$('#mnemonic').val("an error has occurred, unable create mnemonic words.");
			$('#mnemonic').addClass("is-invalid").removeClass("is-valid");
		}
	})
	.catch(function(error) {		
		$('#mnemonic').val("an error has occurred, unable create mnemonic words.");
		$('#mnemonic').addClass("is-invalid").removeClass("is-valid");
	});
}