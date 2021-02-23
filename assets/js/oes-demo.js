/* Make accordion expandable */
oesExpandAccordion(document.getElementsByClassName("accordion"), false)
oesExpandAccordion(document.getElementsByClassName("search-accordion"), true)

function oesExpandAccordion(acc, isTable) {
    var i;
    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function () {
            this.classList.toggle("active");
            var parent = this.parentElement;
            var panel = parent.nextElementSibling;
            if (panel.style.display === "block" || panel.style.display === "table-row") {
                panel.style.display = "none";
            } else {
                if(isTable){
                    panel.style.display = "table-row";
                }
                else{
                    panel.style.display = "block";
                }
            }
        });
    }
}

/* Modal image */
oesExpandImage(document.getElementById("expand-image-modal"));

function oesExpandImage(modal){

    /* Get the image and insert it inside the modal */
    var img = document.getElementById("expand-image");
    var credit = document.getElementById("expand-image-credit");
    var modalImg = document.getElementById("modal-image");

    if(img && modalImg){
        img.onclick = function(){
            modal.style.display = "block";
            modalImg.src = this.src;
        }
    }

    if(img && credit && modalImg){
        credit.onclick = function(){
            modal.style.display = "block";
            modalImg.src = img.src;
        }
    }

    /* add closing span */
    var span = document.getElementsByClassName("expand-image-close")[0];
    if(span){
        span.onclick = function() {
            modal.style.display = "none";
        }
    }
}

/* jump to anchor on page but add margin top */
jQuery(document).ready(function($){ //wait for the document to load
    $('.oes-demo').each(function(){ //loop through each element with the .dynamic-height class
        $('.content-table-header1').css({
            'scroll-margin-top' : $(this).outerHeight() + 10 + 'px'
        });
        $('.content-table-header2').css({
            'scroll-margin-top' : $(this).outerHeight() + 10 + 'px'
        });
        $('.content-table-header3').css({
            'scroll-margin-top' : $(this).outerHeight() + 10 + 'px'
        });
        $('.content-table-header4').css({
            'scroll-margin-top' : $(this).outerHeight() + 10 + 'px'
        });
        $('.content-table-header5').css({
            'scroll-margin-top' : $(this).outerHeight() + 10 + 'px'
        });
        $('.content-table-header6').css({
            'scroll-margin-top' : $(this).outerHeight() + 10 + 'px'
        });
        $('.toc-anchor').css({
            'scroll-margin-top' : $(this).outerHeight() + 10 + 'px'
        });
        $('.oes-anchor').css({
            'scroll-margin-top' : $(this).outerHeight() + 10 + 'px'
        });
    });
});

/* style active links on page */
for (var i = 0; i < document.links.length; i++) {
    if (document.links[i].href === document.URL.split('?')[0] || document.links[i].href === document.URL) {
        if (document.links[i].className === 'check-if-active') {
            document.links[i].className = 'active';
        }
    }
}