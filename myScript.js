var tabButtons = document.querySelectorAll(".TabsContainer .ButtonContainer button");
var tabPanels = document.querySelectorAll(".TabsContainer .TabPanel");

function showPanel(panelIndex,colorCode){
	tabButtons.forEach(function(node){
		node.style.backgroundColor="";
		node.style.color="";
	});
	tabButtons[panelIndex].style.backgroundColor=colorCode;
	tabButtons[panelIndex].style.color="white";

	tabPanels.forEach(function(node){
		node.style.display="none";		
	});
	tabPanels[panelIndex].style.display="block";
	tabPanels[panelIndex].style.backgroundColor=colorCode;

}
showPanel(0,'#35DB29');


/*var quantityInputs = document.getElementsByClassName('cart-quantity-input')
    for (var i = 0; i < quantityInputs.length; i++) {
        var input = quantityInputs[i]
        input.addEventListener('change', quantityChanged)
    }


function quantityChanged(event) {
    var input = event.target
    if (isNaN(input.value) || input.value <= 0) {
        input.value = 1
    }
    updateCartTotal()
}*/