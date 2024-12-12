<script>
$(document).ready(function () {
});
function print_plan_price()
{
  var price_value = $('input[name="plan_price"]:checked').val();
  console.log(price_value);
  $('#plan-price').html(price_value);
}
function print_payment_method()
{
  var payment_value = $('input[name="pay_method"]:checked').val();
  console.log(payment_value);
  if (payment_value =="algerian_credit_card")
  {
    $('#plan-pay-method').html('<p> الدفع عن طريق البطاقة الذهبية أو CIB</p>');
  }else if (payment_value =="baridimob") {
    $('#plan-pay-method').html('<p>لدفع عن طريق تطبيق بريدي موب</p>');
  }else
  {
    $('#plan-pay-method').html('<p>الدفع عن طريق بريد الجزائر CCP</p');
  }
}
function get_selected_plan() 
{
    var planId = $('input[name="plan"]:checked').val();
    $.ajax({
            url: `/supplier/plan-pricing/${planId}`,
            method: 'GET',
            success: function (response) {
                 //add the plan name to the
                 $('#plan-name').html(response[0].name);
                 $('#plan-price').html(`${response[0].price}<sup>د.ج</sup>/الشهر`);
                // console.log(response);
                if(response && response.length <= 0)
                {
                   $('#plan-pricing-step').remove();
                   $('#steps_indicator').html('<span class="step"></span><span class="step"></span><span class="step">');
                }else
                {
                  if ($('#plan-prices-step').length > 0) {
                      // Element exists
                  } else {
                      // Element does not exist
                      $('#plan_pricing').html('<div id="plan-pricing-step" class="tab">نوع الإشتراك:<div id ="pricing-details"></div></div>');
                      $('#steps_indicator').html('<span class="step"></span><span class="step"></span><span class="step"></span><span class="step">');
                  }
                  var details = `<div class="form-check">
                <input class="form-check-input" type="radio" name="plan_price" id="flexRadioDefault1" value="${response[0].price}<sup>د.ج</sup>/شهر" checked onclick="print_plan_price();" >
                <label class="form-check-label" for="flexRadioDefault1">
                  ${response[0].price}<sup>د.ج</sup>/${response[0].duration}
                </label>
              </div>`;
                  response[1].forEach((pricing) => {
                // console.log(pricing);
                details += `<div class="form-check">
                <input class="form-check-input" type="radio" name="plan_price" id="flexRadioDefault1" value="${pricing.price}<sup>د.ج</sup>/${pricing.duration}" onclick="print_plan_price();">
                <label class="form-check-label" for="flexRadioDefault1">
                  ${pricing.price}<sup>د.ج</sup>/${pricing.duration}
                </label>
              </div>`;
                 });
                }
                $('#pricing-details').html(details);
            },
            error: function (error) {
                console.error(error);
                $('#pricing-details').html('فشل في تحميل البيانات');
            },
        });
}
</script>