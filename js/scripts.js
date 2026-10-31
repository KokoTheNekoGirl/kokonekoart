document.addEventListener("DOMContentLoaded", (event) => {
    const artSample = document.querySelector('#art-sample');
    const artBg = document.querySelector('.art-bg');
    
    const comm_btns = document.querySelectorAll('input[type=radio]');
    const add_ons = document.querySelectorAll('input[type=checkbox]');
    const text_labels = document.querySelectorAll('.text-label');
    
    const total_price = document.querySelector('.price');
    
    const paylink = document.querySelector('.paypal-link');
    const pp_url = "https://paypal.me/kokonekoart/";
    const formlink = document.querySelector('.form-link');
    const base_url = "/commission-me/request?";
    
    const pat_l = document.querySelector("label[for='pattern']");
    const sce_l = document.querySelector("label[for='scene']");
    const pat_i = document.querySelector("input[id='pattern']");
    const sce_i = document.querySelector("input[id='scene']");
    const ref = document.querySelector("input[id='ref']");
    
    text_labels.forEach(function (label) {
        label.addEventListener('click', function () {
            let checkbox = document.querySelector("input[id='"+label.getAttribute('data-for')+"']");
            
            if(checkbox.checked){
                checkbox.checked = false;
            } else{
                checkbox.checked = true;
            }
            handle_checkboxes(checkbox);
        });
    });
    
    comm_btns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            if(btn.getAttribute('data-locked') == "false"){
                for(let i = 0; i < add_ons.length; i++){
                    if(add_ons[i].checked && add_ons[i].id=="ref" && btn.name !="bg"){
                        add_ons[i].checked = false;
                        for(let n = 0; n < comm_btns.length; n++){
                            if((btn.name != "char-shots" && comm_btns[n].id == 'hs') || (btn.name != "art-style" && comm_btns[n].id == 'sketch')){
                                comm_btns[n].checked = true;
                                if(comm_btns[n].name =="char-shots"){
                                    artSample.setAttribute("data-char-shot",comm_btns[n].id);
                                } else if(comm_btns[n].name =="art-style"){
                                    artSample.setAttribute("data-art-style",comm_btns[n].id);
                                }
                            }
                        }
                    }
                }
                
                update_formURL();

                if(btn.name=="art-style"){
                    if(btn.id =="sketch" || btn.id =="line"){
                        pat_i.setAttribute("data-locked","true");
                        sce_i.setAttribute("data-locked","true");
                        pat_l.classList.add("locked");
                        sce_l.classList.add("locked");
                        
                        if(pat_i.checked || sce_i.checked){
                            document.querySelector("input[id='trans']").checked = true;
                            artBg.setAttribute("data-bg","trans");
                        }
                    } else {
                        pat_i.setAttribute("data-locked","false");
                        sce_i.setAttribute("data-locked","false");
                        pat_l.classList.remove("locked");
                        sce_l.classList.remove("locked");
                    }
                }

                if(btn.name=="char-shots"){
                    artSample.setAttribute("data-char-shot",btn.id);
                } else if(btn.name=="art-style"){
                    artSample.setAttribute("data-art-style",btn.id);
                } else if(btn.name=="bg") {
                    artBg.setAttribute("data-bg",btn.id);
                }
                calc_total();
            } else{
                btn.checked = false;
                document.querySelector("input[id='"+artBg.getAttribute("data-bg")+"']").checked = true;
            }
        });
    });
    
    add_ons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            handle_checkboxes(btn);
            update_formURL();
        });
    });
    
    function handle_checkboxes(btn){
        if(btn.id=="ref"){
            if(btn.checked){
                pat_i.setAttribute("data-locked","false");
                sce_i.setAttribute("data-locked","false");
                pat_l.classList.remove("locked");
                sce_l.classList.remove("locked");
                for(let i = 0; i < comm_btns.length; i++){
                    if(comm_btns[i].checked && (comm_btns[i].name =="char-shots" || comm_btns[i].name =="art-style")){
                        comm_btns[i].checked = false;
                    }
                }
                artSample.setAttribute("data-char-shot","ref");
                artSample.setAttribute("data-art-style","");
            } else{
                for(let n = 0; n < comm_btns.length; n++){
                    if(comm_btns[n].id == 'hs' || comm_btns[n].id == 'sketch'){
                        comm_btns[n].checked = true;
                        pat_i.setAttribute("data-locked","true");
                        sce_i.setAttribute("data-locked","true");
                        pat_l.classList.add("locked");
                        sce_l.classList.add("locked");
                        artSample.setAttribute("data-char-shot","hs");
                        artSample.setAttribute("data-art-style","sketch");
                    }
                    if(comm_btns[n].checked && (comm_btns[n].id =="pattern" || comm_btns[n].id =="scene" )){
                        document.querySelector("input[id='trans']").checked = true;
                        artBg.setAttribute("data-bg","trans");
                    }
                }
            }
    
        }
        calc_total();
    }
    
    function calc_total(){
        let total = 0;
        
        for(let i = 0; i < comm_btns.length; i++){
            if(comm_btns[i].checked){
                total += parseFloat(comm_btns[i].value);
            }
        }
        
        for(let i = 0; i < add_ons.length; i++){
            if(add_ons[i].checked){
                total += parseFloat(add_ons[i].value);
            }
        }
        
        total_price.innerHTML = total;
        paylink.href = pp_url + total;
    }
    
    function update_formURL(){
        let form_url = base_url;
        for(let i = 0; i < comm_btns.length; i++){
            if(comm_btns[i].checked){
                form_url += comm_btns[i].name+"="+comm_btns[i].id+"&";
            }
        }
        if(ref.checked){
            form_url+="char-shots=ref&";
        }
        form_url+="add-ons=";
        for(let i = 0; i < add_ons.length; i++){
            if(add_ons[i].checked && add_ons[i].id!="ref"){
                form_url+=add_ons[i].id+",";
            }
        }
        formlink.href = form_url;
    }

    const starContainer = document.getElementById("star-container");

    //Math.seedrandom("CDR");
    let stars = ["✦", "✧", "★", "✬", "✯", "✵", "✶", "✷", "✹", "✸"];

    for (let i = 0; i < 200; i++) {
        const element = document.createElement("div");
        element.style.top = `${Math.random() * 100}%`;
        element.style.left = `${Math.random() * 100}%`;
        let sizeX = Math.random() * 7 + 1;
        let sizeY = ~~(Math.random() * 3) + 1;
        //element.style.width = `${sizeX}px`;
        //element.style.height = `${sizeX}px`;
        element.innerHTML = stars[~~(Math.random() * stars.length)];
        element.style.fontSize = sizeX + "px";
        element.style.animation = `${
            7000 / sizeX + Math.random() * (7000 / sizeX)
        }ms linear ${Math.random() * 5000}ms alternate infinite twinkle`;
        starContainer.appendChild(element);
        element.setAttribute("class", "star");
    }
});