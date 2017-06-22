
//Dynamically insert child nodes with their own id (a title, table and a form composed of an input and a button ) to parentElement. Onclick, the table showing all the words in topic.words appears and clear input field (call both functions)

var parentElement = document.getElementById('selection');
parentElement.appendChild(document.createElement("hr"));

function dynamicInsert(parentElement) {
    for (i = 0; i < sortedJournals.length; i++) {
    //for (i = 0; i < sortedSections.length; i++) {
        
        //var section = sortedSections[i]
        var journal = sortedJournals[i]

        
        // Container will contain journal name
        var container = document.createElement('div');
        var idContainer = 'container' + i;
        container.setAttribute('id', idContainer);
        container.setAttribute('class', 'container');

        //container.innerHTML = section;
        container.innerHTML = journal.journalName
        container.appendChild(document.createElement("br"));
        
        
        
        // Create checkboxes for each journal
        for (j = 0; j < Object.keys(journal.sectionUrls).length; j++) {
        //for (j = 0; j < (sections[section]).length; j++) {
            
            //var journal = sections[section][j];
            var section = Object.keys(journal.sectionUrls)[j];
            
            var cb = document.createElement('input');
            var cbId = 'cb' + i + j;
            cb.setAttribute('id', cbId);
            cb.setAttribute('class', 'iniCB');
            cb.setAttribute('type', 'checkbox');
            cb.setAttribute('name', 'check_list[]');
            cb.setAttribute('value', journal.journalName+'_'+section);
            //document.getElementById(cbId).value = journal.journalName+'_'+section;
            
            var lab = document.createElement('label');
            var labId = 'lab' + i + j;
            lab.setAttribute('id', labId);
            lab.setAttribute('for', cbId);
            //lab.appendChild(document.createTextNode(journal));
            lab.appendChild(document.createTextNode(section));
            
            container.appendChild(cb);
            container.appendChild(lab);
            
            //console.log("append: " +labId);
        }
    
        
        // Line break after the topic Header1
        parentElement.appendChild(document.createElement("br"));

        
        // append the form with its children to Header1
        parentElement.appendChild(container);
        parentElement.appendChild(document.createElement("hr"));
    }
    var submitButton = document.createElement("input");
    submitButton.setAttribute('id', 'submitButton');
    submitButton.setAttribute('type', 'submit');
    submitButton.setAttribute('name', 'submit');
    submitButton.setAttribute('value', "Let's go!");
    
    parentElement.appendChild(submitButton);
}

dynamicInsert(parentElement)





//Record the sections selected by the user
window.addEventListener('load', registerEvents, false);


//var selectedSections = {}
var selectedSections = []

//WARNING: to attach an event handler to dynamically added elements, use this. as a parameter (not button here). 
function registerEvents(e) {
    //for (i = 0; i < sortedSections.length; i++){
    for (i = 0; i < sortedJournals.length; i++){
        
        //var section = sortedSections[i]
        var journal = sortedJournals[i]
        
        //for (j = 0; j < (sections[section]).length; j++){
        for (j = 0; j < Object.keys(journal.sectionUrls).length; j++){
            
            var id = i.toString()+j.toString()
            var cb = document.getElementById('cb' + id);
            //Dynamically attach event handler to cb, call an external function with e
            cb.addEventListener('change', function(e) {
                recordSection(e, this.id);
                },
                                false);
        }
    }
}




// Update selectedSections according to whether the button is checked or not
function recordSection(e, cbid) {
    var id = cbid.slice(-2);
    var journalid = cbid.charAt(cbid.length - 2);
    var journal = sortedJournals[journalid]
    var cb = document.getElementById(cbid);
    var lab = document.getElementById('lab'+id);
        
    // if the check button is checked
    if (cb.checked) {
    // add to selectedSections dictionnary the journal as key and the section as value
        //selectedSections[id] = [journal.journalName, lab.innerHTML];
        selectedSections.push(id)
    // if not checked
    } else {
        // look for all sections from the specific journal in selectedSections
        if (id in selectedSections){
            var index = array.indexOf(id);
            selectedSections.splice(index, 1);
            //delete selectedSections[id];
            }
        }
}



//Send data to display page
function send_onclick() {    
    sessionStorage.setItem('selectedSections', JSON.stringify(selectedSections));
    window.location.href = "public_harrispierce/display.html";
    }


// When the user clicks on div, open the popup
function myFunction() {
    var popup = document.getElementById("myPopup");
    popup.classList.toggle("show");
    console.log('toggle');
    }


