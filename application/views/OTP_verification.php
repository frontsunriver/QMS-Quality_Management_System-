<style type="text/css">
    #wrapper {
        font-family: Lato;
        font-size: 1.5rem;
        text-align: center;
        box-sizing: border-box;
        color: #333;
    }
    #wrapper #dialog {
        border: solid 1px #ccc;
        margin: 10px auto;
        padding: 20px 30px;
        display: inline-block;
        box-shadow: 0 0 4px #ccc;
        background-color: #faf8f8;
        overflow: hidden;
        position: relative;
        max-width: 450px;
    }
    #wrapper #dialog h3 {
        margin: 0 0 10px;
        padding: 0;
        line-height: 1.25;
    }
    #wrapper #dialog span {
        font-size: 90%;
    }
    #wrapper #dialog #form {
        max-width: 240px;
        margin: 25px auto 0;
    }
    #wrapper #dialog #form input {
        margin: 0 5px;
        text-align: center;
        line-height: 80px;
        font-size: 50px;
        border: solid 1px #ccc;
        box-shadow: 0 0 5px #ccc inset;
        outline: none;
        width: 20%;
        -webkit-transition: all 0.2s ease-in-out;
        transition: all 0.2s ease-in-out;
        border-radius: 3px;
    }
    #wrapper #dialog #form input:focus {
        border-color: purple;
        box-shadow: 0 0 5px purple inset;
    }
    #wrapper #dialog #form input::-moz-selection {
        background: transparent;
    }
    #wrapper #dialog #form input::selection {
        background: transparent;
    }
    #wrapper #dialog #form button {
        margin: 30px 0 50px;
        width: 100%;
        padding: 6px;
        background-color: #b85fc6;
        border: none;
        text-transform: uppercase;
    }
    #wrapper #dialog button.close {
        border: solid 2px;
        border-radius: 30px;
        line-height: 19px;
        font-size: 120%;
        width: 22px;
        position: absolute;
        right: 5px;
        top: 5px;
    }
    #wrapper #dialog div {
        position: relative;
        z-index: 1;
    }
    #wrapper #dialog img {
        position: absolute;
        bottom: -70px;
        right: -63px;
    }

</style>
<section class="LoginBox">
   <form name="login_form" action="<?=base_url('auth/login');?>" method="post">
       <div style="display: none;">
           <input type="hidden" name="login[u]" value="<?=$username?>">
           <input type="hidden" name="login[p]" value="<?=$password?>">
           <input type="hidden" name="u_t" value="<?=$user_type?>">
       </div>
       <div id="wrapper">
           <div id="dialog">
               <button type="button" class="close">×</button>
               <h3>Please enter the 4-digit verification code we sent via <?= ($via_method == 'phone' ? 'SMS':'EMAIL')?>:</h3>
               <span>(we want to make sure it's you before we contact our movers)</span>
               <div id="form">
                   <input type="text" maxLength="1" name="code[]" size="1" min="0" max="9" pattern="[0-9]{1}" />
                   <input type="text" maxLength="1" name="code[]" size="1" min="0" max="9" pattern="[0-9]{1}" /><input type="text" maxLength="1" name="code[]" size="1" min="0" max="9" pattern="[0-9]{1}" /><input type="text" maxLength="1" name="code[]" size="1" min="0" max="9" pattern="[0-9]{1}" />
                   <button class="btn btn-primary btn-embossed">Verify</button>
               </div>

               <div>
                   Didn't receive the code?<br />
                   <a href="javascript:void()" onclick="f()">Send code again</a><br />
               </div>
           </div>
       </div>
   </form>
</section><!--LoginBox-->

<script type="text/javascript">
    function f() {
        window.location.reload();
    }
    $(function() {
        'use strict';
        $('.close').click(function () {
            window.location.href = '<?=base_url('auth/login');?>'
        });
        var body = $('body');

        function goToNextInput(e) {
            var key = e.which,
                t = $(e.target),
                sib = t.next('input');

            if (key != 9 && (key < 48 || key > 57)) {
                e.preventDefault();
                return false;
            }

            if (key === 9) {
                return true;
            }

            if (!sib || !sib.length) {
                sib = body.find('input').eq(0);
            }
            sib.select().focus();
        }

        function onKeyDown(e) {
            var key = e.which;

            if (key === 9 || (key >= 48 && key <= 57)) {
                return true;
            }

            e.preventDefault();
            return false;
        }

        function onFocus(e) {
            $(e.target).select();
        }

        body.on('keyup', 'input', goToNextInput);
        body.on('keydown', 'input', onKeyDown);
        body.on('click', 'input', onFocus);

    })
</script>
