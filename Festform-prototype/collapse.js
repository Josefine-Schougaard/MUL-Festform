// Collapsible box

const toggleCollapse = (trigger) =>{
    const parent = trigger.parentElement;

    for(child of parent.children){
        if(child.classList.contains('collapse-content')){
            child.classList.toggle('open');
            if(child.style.maxHeight){
                child.style.maxHeight = null;
            }
            else{
                child.style.maxHeight = child.scrollHeight + 'px';
            }
        }
    }
};

document.querySelectorAll(".collapse").forEach(collapse =>{
    collapse.addEventListener('click', () =>{
        toggleCollapse(collapse);
    });
});