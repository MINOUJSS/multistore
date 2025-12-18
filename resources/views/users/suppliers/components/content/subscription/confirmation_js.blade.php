<script>
    $(document).ready(function() {
        var plan_id = $('input[name="plan"]:checked').val();
        print_plan_price();
        print_sub_plan_id();
        get_plan_authorizations(plan_id);

        $(document).on('click', 'input[name="plan_price"]', function() {
            print_plan_price();
            print_sub_plan_id();
        });

        $(document).on('click', 'input[name="pay_method"]', function() {
            print_payment_method();
        });

        $(document).on('click', 'input[name="plan"]', function() {
            get_selected_plan();
            remiz_a_zero_sub_plan_id();
        });

    });

    function remiz_a_zero_sub_plan_id() {
        $('#sub_plan_id').val(0);
    }

    function print_sub_plan_id() {
        var sub_plan_id = $('input[name="plan_price"]:checked').data('sub-plan-id');
        console.log(sub_plan_id);
        $('#sub_plan_id').val(sub_plan_id);
    }

    function print_plan_price() {
        var price_value = $('input[name="plan_price"]:checked').val();
        console.log(price_value);
        $('#plan-price').html(price_value);
    }

    function print_payment_method() {
        var payment_value = $('input[name="pay_method"]:checked').val();
        console.log(payment_value);
        if (payment_value == "algerian_credit_card") {
            $('#plan-pay-method').html('<p> الدفع عن طريق البطاقة الذهبية أو CIB</p>');
        } else if (payment_value == "baridimob") {
            $('#plan-pay-method').html('<p>لدفع عن طريق تطبيق بريدي موب</p>');
        } else {
            $('#plan-pay-method').html('<p>الدفع عن طريق بريد الجزائر CCP</p');
        }
    }

    function get_selected_plan() {
        var planId = $('input[name="plan"]:checked').val();
        $.ajax({
            url: `/supplier-panel/plan-pricing/${planId}`,
            method: 'GET',
            success: function(response) {
                //add the plan name to the
                $('#plan-name').html(response[0].name);
                $('#plan-price').html(`${response[0].price}<sup>د.ج</sup>/30 يوم`);
                //console.log(response[0].price);
                if (response[0].price == 0) {
                    $('#non_methode').show();
                    $('#the_methods').hide();
                    $('#plan-pay-method').hide();
                } else {
                    $('#non_methode').hide();
                    $('#the_methods').show();
                    $('#plan-pay-method').show();
                }

                if (response && response.length <= 0) {
                    $('#plan-pricing-step').remove();
                    $('#steps_indicator').html(
                        '<span class="step"></span><span class="step"></span><span class="step">');

                } else {
                    if ($('#plan-prices-step').length > 0) {
                        // Element exists
                    } else {
                        // Element does not exist
                        $('#plan_pricing').html(
                            '<div id="plan-pricing-step" class="tab">نوع الإشتراك:<div id ="pricing-details"></div></div>'
                            );
                        $('#steps_indicator').html(
                            '<span class="step"></span><span class="step"></span><span class="step"></span><span class="step">'
                            );
                    }
                    var details = `
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="plan_price" id="flexRadioDefault1" data-sub-plan-id="0" value="${response[0].price}<sup>د.ج</sup>/${response[0].price == 0 ? 'مدى الحياة' : '30 يوم'}" checked onclick="print_plan_price();">
                      <label class="form-check-label" for="flexRadioDefault1">
                        ${response[0].price}<sup>د.ج</sup>/${response[0].price == 0 ? 'مدى الحياة' : '30 يوم'}
                      </label>
                    </div>`;
                    response[1].forEach((pricing) => {
                        // console.log(pricing);
                        details += `<div class="form-check">
                <input class="form-check-input" type="radio" name="plan_price" id="flexRadioDefault1" data-sub-plan-id="${pricing.id}" value="${pricing.price}<sup>د.ج</sup>/${pricing.duration} يوم" onclick="print_plan_price();">
                <label class="form-check-label" for="flexRadioDefault1">
                  ${pricing.price}<sup>د.ج</sup>/${pricing.duration} يوم
                </label>
              </div>`;
                    });
                }
                $('#pricing-details').html(details);
            },
            error: function(error) {
                console.error(error);
                $('#pricing-details').html('فشل في تحميل البيانات');
            },
        });
    }
    //get plan authorizations
    function get_plan_authorizations(plan_id) {
        $.ajax({
            url: `/supplier-panel/plan-authorization/${plan_id}`,
            method: 'GET',
            success: function(response) {
                //add the plan name to the
                $('#plan-authorizations').html(response);
            },
            error: function(error) {
                console.error(error);
                $('#plan-authorizations').html('فشل في تحميل البيانات');
            },
        });
    }
    // --------------------------------------
    // دالة التحكم في التنقل بين الخطوات
    // --------------------------------------
    let currentTab = 0; // البداية من أول تبويب

    function showTab(n) {
        const tabs = document.getElementsByClassName("tab");
        for (let i = 0; i < tabs.length; i++) {
            tabs[i].style.display = "none";
        }
        tabs[n].style.display = "block";

        // إظهار أو إخفاء الأزرار حسب التبويب
        if (n === 0) {
            document.getElementById("prevBtn").style.display = "none";
        } else {
            document.getElementById("prevBtn").style.display = "inline";
        }

        if (n === (tabs.length - 1)) {
            document.getElementById("nextBtn").innerHTML = "تأكيد الإشتراك";
        } else {
            document.getElementById("nextBtn").innerHTML = "التالي";
        }

        fixStepIndicator(n);
    }

    function nextPrev(n) {
        const tabs = document.getElementsByClassName("tab");

        // إخفاء التبويب الحالي
        tabs[currentTab].style.display = "none";

        // تحديد التبويب التالي أو السابق
        currentTab += n;

        // إذا انتهينا من كل التبويبات، أرسل النموذج
        if (currentTab >= tabs.length) {
            document.getElementById("regForm").submit();
            return false;
        }

        // إظهار التبويب الجديد
        showTab(currentTab);
    }

    function fixStepIndicator(n) {
        const steps = document.getElementsByClassName("step");
        for (let i = 0; i < steps.length; i++) {
            steps[i].className = steps[i].className.replace(" active", "");
        }
        steps[n].className += " active";
    }

    // استدعاء أول تبويب عند تحميل الصفحة
    document.addEventListener("DOMContentLoaded", function() {
        showTab(currentTab);
    });
</script>
