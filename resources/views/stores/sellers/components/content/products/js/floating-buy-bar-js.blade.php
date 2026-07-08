<script>
const buyButton = document.getElementById("buyNowButton");

const floatingBar = document.getElementById("floatingBuyBar");

const floatingButton = document.getElementById("floatingBuyButton");

window.addEventListener("scroll", function () {

    const rect = buyButton.getBoundingClientRect();

    if(rect.bottom < 0){

        floatingBar.style.display = "block";

    }else{

        floatingBar.style.display = "none";

    }

});

floatingButton.addEventListener("click",function(){

    buyButton.click();

});
</script>