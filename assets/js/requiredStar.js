const requiredLabels = document.querySelectorAll('label.required');
if (requiredLabels!=null){

    for( i = 0; i<requiredLabels.length;i++){
        const requiredStar = document.createElement('span');
        requiredStar.textContent="*";
        requiredStar.classList.add("required_form_color");
        requiredLabels[i].insertAdjacentElement("afterend", requiredStar);
    }
}