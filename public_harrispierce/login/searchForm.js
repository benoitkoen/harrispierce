

function insertCB() {    
    var journalCB = document.getElementById('journalCB');
    console.log('ok on a journalCB'+journalCB.id)
    
    for (k = 0; k < journalList.length; k++){
        
        var journalName = journalList[k].journalName;
        
        var cb = document.createElement('input');
        var cbId = 'cbSearch' + k;
        cb.setAttribute('id', cbId);
        cb.setAttribute('class', 'searchFormJournals');
        cb.setAttribute('type', 'checkbox');
        cb.setAttribute('name', 'check_list_search[]');
        cb.setAttribute('value', journalName);
        
        var lab = document.createElement('label');
        var labId = 'lab' + i + j;
        lab.setAttribute('id', labId);
        lab.setAttribute('for', cbId);
        lab.setAttribute('class', 'searchFormLabel');
        lab.appendChild(document.createTextNode(journalName));

        journalCB.appendChild(cb);
        journalCB.appendChild(lab);
    }
}




function setDate(){
    document.getElementById('dateInput').defaultValue = new Date();
}


$(document).ready(function(){
    $("#searchBar").click(function(){
        $("#searchForm").hide();
        $("#show_onclick_form").show();
    });
    $("#searchButton").click(function(){
        $("#searchForm").hide();
        $("#show_onclick_form").show();
    });
    
    
    
    $("#quitSearch").click(function(){
        $("#searchForm").show();
        $("#show_onclick_form").hide();
    });
});





function addListeners(){
    document.getElementById('#show_onclick_form').addEventListener('mousedown', mouseDown, false);
    window.addEventListener('mouseup', mouseUp, false);

}

function mouseUp()
{
    window.removeEventListener('mousemove', divMove, true);
}

function mouseDown(e){
  window.addEventListener('mousemove', divMove, true);
}

function divMove(e){
    var div = document.getElementById('#show_onclick_form');
  div.style.position = 'absolute';
  div.style.top = e.clientY + 'px';
  div.style.left = e.clientX + 'px';
}


