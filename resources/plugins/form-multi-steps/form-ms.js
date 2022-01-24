(function($) {
    $.fn.extend({
        loadsteps: function() {
            var frm = $(this);
            var npasos=frm.children('div .step').length;
            var current_fs;
            frm.find('.step').eq(0).show();
            frm.find('.steps li').css('width', (100 / npasos) + "%");

            $(this).find('.msnext-step').click(function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                current_fs = frm.children('div .step:visible');
                var steps_fs=frm.find('.step');
                current_step=steps_fs.index(current_fs);
                current_fs.hide();
                steps_fs.eq(current_step + 1).show();
                current_step++;
                //activate next step on progressbar using the index of next_fs
                frm.find('.steps li').eq(current_step).addClass("active"); // OK
                //show the next fieldset
                pcpaso = (current_step  + 1) / npasos * 100;
                frm.find('.progress-bar').css('width', pcpaso + "%");
                return false;
            });
            $(this).find('.msprevious-step').click(function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                current_fs = frm.children('div .step:visible');
                var steps_fs=frm.find('.step');
                current_step=steps_fs.index(current_fs);
                current_fs.hide();
                steps_fs.eq(current_step -1).show();
                
                //activate next step on progressbar using the index of next_fs
                frm.find('.steps li').eq(current_step).removeClass("active"); // OK
                //show the next fieldset
                pcpaso = (current_step ) / npasos * 100;
                frm.find('.progress-bar').css('width', pcpaso + "%");
                return false;
            });
        },
        next_step: function() {
                var frm = $(this);
                npasos=(frm.children('div .step').length + 1);
                current_fs = frm.children('div .step:visible');
                var steps_fs=frm.find('.step');
                current_step=steps_fs.index(current_fs);
                current_fs.hide();
                steps_fs.eq(current_step + 1).show();
                current_step++;
                //activate next step on progressbar using the index of next_fs
                frm.find('.steps li').eq(current_step).addClass("active"); // OK
                //show the next fieldset
                pcpaso = (current_step  + 1) / npasos * 100;
                frm.find('.progress-bar').css('width', pcpaso + "%");
                return false;
        },
        previous_step: function() {

                var frm = $(this);
                npasos=(frm.children('div .step').length + 1);
                current_fs = frm.children('div .step:visible');
                var steps_fs=frm.find('.step');
                current_step=steps_fs.index(current_fs);
                current_fs.hide();
                steps_fs.eq(current_step -1).show();
                
                //activate next step on progressbar using the index of next_fs
                frm.find('.steps li').eq(current_step).removeClass("active"); // OK
                //show the next fieldset
                pcpaso = (current_step ) / npasos * 100;
                frm.find('.progress-bar').css('width', pcpaso + "%");
                return false;
            
        },
        go_step: function(go_step) {
                var frm = $(this);
                npasos=(frm.children('div .step').length + 1);
                current_fs = frm.children('div .step:visible');
                var steps_fs=frm.find('.step');
                current_step=steps_fs.index(current_fs);
                current_fs.hide();
                steps_fs.eq(go_step).show();
                
                //activate next step on progressbar using the index of next_fs
                frm.find('.steps li').eq(go_step).addClass("active"); // OK
                //show the next fieldset
                pcpaso = (go_step) / npasos * 100;
                frm.find('.progress-bar').css('width', pcpaso + "%");
                return false;
        }

    });
})(jQuery)