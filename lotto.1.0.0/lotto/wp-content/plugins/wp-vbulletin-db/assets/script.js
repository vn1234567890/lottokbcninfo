/**
 * Created by VLZ on 02.04.2015.
 */
(function () {

    var vbrss2_switchtab = function (e) {
        var cls = this.classList;
        if (cls.contains('vbrss2_active')) {
            return;
        }
        var li = e.target;
        var tabs = li.parentElement.querySelectorAll('li');
        var uls = li.parentElement.parentElement.querySelectorAll('ul');
        for (var i = 0; i< tabs.length;i++){
            if (tabs[i] === li){
                li.classList.add('vbrss2_active');
                uls[i+1].classList.add('vbrss2_active');
            }else{
                tabs[i].classList.remove('vbrss2_active');
                uls[i+1].classList.remove('vbrss2_active');
            }
        }
    };
    var vbrss_init = function () {
        var tabcontrols = document.querySelectorAll('.vbrss2_tabs');
        var len = tabcontrols.length;
        for (var i = 0; i < len; i++) {
            tabcontrols[i].addEventListener('click', vbrss2_switchtab);
        }

    };
    window.addEventListener('load', vbrss_init);
})();