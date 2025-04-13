(function($) {
    "use strict";

    let current_fs, next_fs, previous_fs; //fieldsets
    let left, opacity, scale; //fieldset properties which we will animate
    let animating; //flag to prevent quick multi-click glitches

    //* Form js
    function verificationForm(){
        //jQuery time

        $(".radio-selection").click(function() {
            if (animating) return false;
            animating = true;

            current_fs = $(this).parents('fieldset');

            let fsId;
            if ($(this).hasClass("dependent"))
                fsId = `fs-${$('input[name="ai_system_type"]:checked').attr('id')}`;
            else
                fsId = $(this).data('fs');
            next_fs = $(`#${fsId}`); // $(this).parents('fieldset').next();


            //activate next step on progressbar using the index of next_fs
            // $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

            toNextFieldset(next_fs, current_fs, scale, left, opacity)
        });

        $(".next").click(function () {
            if (animating) return false;
            animating = true;

            current_fs = $(this).parents('fieldset');

            let fsId;
            if ($(this).hasClass("dependent"))
                fsId = `fs-${$('input[name="ai_system_type"]:checked').attr('id')}`;
            else
                fsId = $(this).data('fs');
            next_fs = $(`#${fsId}`); // $(this).parents('fieldset').next();


            //activate next step on progressbar using the index of next_fs
            // $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

            toNextFieldset(next_fs, current_fs, scale, left, opacity)
        });

        $(".previous").click(function () {
            if (animating) return false;
            animating = true;

            current_fs = $(this).parents('fieldset');
            let fsId = $(this).data('fs');
            previous_fs = $(`#${fsId}`); // $(this).parents('fieldset').prev();


            //de-activate current step on progressbar
            // $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

            previous_fs[0].classList.add('d-flex', 'flex-column', 'justify-content-between');
            current_fs[0].classList.remove('d-flex', 'flex-column', 'justify-content-between');

            //show the previous fieldset
            previous_fs.show();

            //hide the current fieldset with style
            current_fs.animate({
                opacity: 0
            }, {
                step: function (now, mx) {
                    //as the opacity of current_fs reduces to 0 - stored in "now"
                    //1. scale previous_fs from 80% to 100%
                    scale = 0.8 + (1 - now) * 0.2;
                    //2. take current_fs to the right(50%) - from 0%
                    left = ((1 - now) * 50) + "%";
                    //3. increase opacity of previous_fs to 1 as it moves in
                    opacity = 1 - now;
                    current_fs.css({
                        'left': left
                    });
                    previous_fs.css({
                        'transform': 'scale(' + scale + ')',
                        'opacity': opacity
                    });
                },
                duration: 400,
                complete: function () {
                    current_fs.hide();
                    animating = false;
                },
                //this comes from the custom easing plugin
                easing: 'easeInOutBack'
            });

            window.scrollTo(0, 0);
        });

        $(".submit").click(function () {
            return false;
        })
    };

    //* Add Phone no select
    function phoneNoselect(){
        if ( $('#msform').length ){
            //$("#phone_number").intlTelInput();
            $("#phone_number").intlTelInput("setNumber", "+880");
        };
    };

    //* Select js
    function nice_Select(){
        if ( $('.product_select').length ){
            $('select').niceSelect();
        };
    };

    function toNextFieldset(next_fs, current_fs, scale, left, opacity) {

        next_fs[0].classList.add('d-flex', 'flex-column', 'justify-content-between');
        current_fs[0].classList.remove('d-flex', 'flex-column', 'justify-content-between');

        //show the next fieldset
        next_fs.show();

        //hide the current fieldset with style
        current_fs.animate({
            opacity: 0
        }, {
            step: function (now, mx) {
                //as the opacity of current_fs reduces to 0 - stored in "now"
                //1. scale current_fs down to 80%
                scale = 1 - (1 - now) * 0.2;
                //2. bring next_fs from the right(50%)
                left = (now * 50) + "%";
                //3. increase opacity of next_fs to 1 as it moves in
                opacity = 1 - now;
                current_fs.css({
                    'transform': 'scale(' + scale + ')',
                    /*'position': 'absolute'*/
                });
                next_fs.css({
                    'left': left,
                    'opacity': opacity
                });
            },
            duration: 400,
            complete: function () {
                current_fs.hide();
                animating = false;
            },
            //this comes from the custom easing plugin
            easing: 'easeInOutBack'
        });
        window.scrollTo(0, 0);
    }

    $("input[name='tools_area']").on("click", function () {
        if ($(this).val() === 'Other')
            $("#domain-next").removeClass('d-none')
        else
            $("#domain-next").addClass('d-none')
    });

    /*Function Calls*/
    verificationForm ();
    phoneNoselect ();
    nice_Select ();

    $(".submit-result").click(function(e) {

        let $this = $(this);
        $("#section-alert").addClass('d-none').text("");
        $this.text('Processing...').attr('disabled', true);

        e.preventDefault();

        $.ajax({
            url: baseUrl + '/submit-evaluation',
            data: $("#msform").serializeArray(),
            type: 'POST',
            beforeSend: function( xhr ) {
                $(this).text('Submitting...');
            }
        })
            .fail(function() {
                let msg = "something went wrong! Please refresh the page and try again.";
                console.log(msg);
                $("#section-alert").text(msg)
                $("#section-alert").removeClass('d-none');
            })
            .done(function( data ) {

                $(this).text('Submit');
                console.log(data)

                if (data.success) {

                    window.location.href = baseUrl + '/user/dashboard'; //data.data.route;
                } else {
                    console.log(data.error);
                    for (let errArray in data.error) {
                        console.log(data.error[errArray])
                        data.error[errArray].forEach((err) => {
                            document.querySelector("#section-alert").innerText += err;
                        })
                    }
                    $("#section-alert").removeClass('d-none');

                    $this.text('Submit').removeAttr('disabled');
                }

            });

    });
})(jQuery);
