
       (function () {
           if (! ('position' in document.createElement ('progress'))) {
               var elements = document.querySelectorAll ('meter, progress');
               for (var i = 0, j = elements.length; i < j; i++) {
                 elements [i].style.border = "1px solid red";
                 elements [i].style.height = "12px";
                 elements [i].style.display = "inline-block";
                 elements [i].style.webkitAppearance = "none";
               }
               
               return ;
           }
           
           document.getElementById ('no-support').style.display = 'none';
           
           /** Setup the <progress> JavaScript example **/
           var progressExample = document.getElementById ('progress-javascript-example');
           progressExample.min = 50;
           progressExample.max = 122;
               
           setInterval (function ()
           {
               progressExample.value = progressExample.min + Math.random () * (progressExample.max - progressExample.min);
           
           }, 1000);
           
           /** We'd like some fancy <meter> examples too **/
           var meterExample = document.getElementById ('meter-javascript-example');
           meterExample.min = 0;
           meterExample.max = 100;
           meterExample.value = 50;
           meterExample.low  = 20;
           meterExample.high = 80;
           meterExample.optimum = 65;
               
           setInterval (function ()
           {
               meterExample.value   = meterExample.min + Math.random () * (meterExample.max - meterExample.min);
               meterExample.optimum = 65 + (5 - Math.random () * 10);
           
           }, 1000);
           
       })();
