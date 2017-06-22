
function loading()
{
    document.getElementById("loader").style.display = 'none';
    document.getElementById("wait").style.display = 'none'
    document.getElementById("header1").style.display = 'block';
}
window.onload = loading;



//Get back the data from welcome page as a string
var stringifiedSelectedSections = sessionStorage.getItem('selectedSections');
//Turn the stringified object back to an object
var selectedSections2 = JSON.parse(stringifiedSelectedSections);

//kept contains, for each journal, a dict with section as key and url as value
kept = {}


for (i in selectedSections2){
    journalInd = parseInt(selectedSections2[i][1])
    sectionInd = parseInt(selectedSections2[i][0])
    
    journal = sortedJournals[journalInd].journalName
    section = Object.keys(sortedJournals[journalInd].sectionUrls)[sectionInd]
    
    console.log(journal);
    console.log(section);
    
    url = sortedJournals[journalInd].sectionUrls[section]
    
    //if journal already in kept, just add a section with url to that journal (object)
    if (journal in kept){
        kept[journal][section] = url
    } else {
        kept[journal] = {}
        kept[journal][section] = url
    }
}

//parent element is the top header (little desciption text)
var parentElement = document.getElementById('header1');
parentElement.appendChild(document.createElement("hr"));

function dynamicInsert(parentElement) {
    //For each Journal
    for (i = 0; i < Object.keys(kept).length; i++) {
        
        var journal = Object.keys(kept)[i]

        // Container contains journal name
        var container = document.createElement('div');
        var idContainer = 'container' + i;
        container.setAttribute('id', idContainer);
        container.setAttribute('class', 'container');

        container.innerHTML = journal
        container.appendChild(document.createElement("br"));

        //For each section
        for (j = 0; j < Object.keys(kept[journal]).length; j++) {

            var section = Object.keys(kept[journal])[j];
            var url = kept[journal][section]
            
            //scrapping() returns a list of 2 lists: a list of titles, a list of urls
            var titles = scrapping(url, journal)[0];
            var hrefs = scrapping(url, journal)[1];
            var teasers = scrapping(url, journal)[2];
            
            var pHeader = document.createElement('p'); //Section in each journal
            pHeader.setAttribute('class', 'pHeader')
            pHeader.innerHTML = section;
            container.appendChild(pHeader);
            
            var TitlesList = document.createElement('ul'); //Create undordered list under pHeader
            pHeader.appendChild(TitlesList);
 
            //The 'une' for each section
            for (k = 0; k < titles.length; k++) {
                var titleli = document.createElement('li'); //<li> element for each 'une'
                titleli.setAttribute('class', 'hoverinfo');
                
                var titleanch = document.createElement('a'); //<a> for each <li>
                titleanch.setAttribute('target', '_blank')
                titleanch.setAttribute('href', hrefs[k]); //link for each <a>
                titleanch.innerHTML = titles[k]; //the 'une' for each <a>
                
                var teaserBox = document.createElement('p');
                teaserBox.setAttribute('class', 'teaser')
                teaserBox.innerHTML = teasers[k];
                
                titleli.appendChild(titleanch);
                titleli.appendChild(teaserBox);
                TitlesList.appendChild(titleli);
            }
          
            
        }

        parentElement.appendChild(container);
        parentElement.appendChild(document.createElement("hr"));
    }
        
}


dynamicInsert(parentElement)




function scrapping(url, journal){
    
    var titles = []; //will contain the 10 'une' for a specific section of a journal
    var hrefs = [];
    var teasers = [];
    
    var q = encodeURIComponent('select * from html where url="'+url+'"');
    var yql = 'http://query.yahooapis.com/v1/public/yql?q='+q;
    
    //Each journal has a specific scrapping method
    //WSJ
    if (journal === 'Wall Street Journal'){
        
        if (url === 'https://www.wsj.com/news/world'
            || url === 'https://www.wsj.com/news/business'
            || url === 'https://www.wsj.com/news/opinion'){
        
            var divclass = 'hed heading-2';

            var execute_ajax = (function(){
                $.ajax({
                async:false,
                type: "GET",
                url: yql,
                dataType: "xml",
                success: function (data) {
                    var nodes = data.getElementsByClassName(divclass);

                    for (l = 0; l < 10; l++){
                        console.log($(nodes[l]));
                        if (typeof(nodes[l]) !== 'undefined'){ //if there less than 10 'une'
                            hrefs.push(
                                $(nodes[l]).children('a.subPrev.headline').attr('href'));
                            titles.push(
                                $(nodes[l]).children('a.subPrev.headline').html());

                            if (typeof(nodes[l]) !== 'undefined'){ //if no teaser

                                teasers.push(
                                    $(nodes[l]).parents('header.hedgroup').nextAll('div.text-wrapper').children('p.summary').text());

                            } else {
                                teasers.push('No teaser available');
                            }
                        }
                    }
                    }
                });
            })();
            return [titles, hrefs, teasers];
            
        //ECO    
        } else if (url === 'https://www.wsj.com/news/economy') {
            
            var divclass = 'hedgroup';

            var execute_ajax = (function(){
                $.ajax({
                async:false,
                type: "GET",
                url: yql,
                dataType: "xml",
                success: function (data) {
                    var nodes = data.getElementsByClassName(divclass);

                    for (l = 0; l < 10; l++){
                        
                        if (typeof(nodes[l]) !== 'undefined'){ //if there less than 10 'une'
                            hrefs.push(
                                $(nodes[l]).find('a').attr('href'));
                            titles.push(
                                $(nodes[l]).find('a').html());

                            if ($(nodes[l]).nextAll('div.text-wrapper').length !== 0){ //if no teaser

                                teasers.push(
                                    $(nodes[l]).nextAll('div.text-wrapper').children('p.summary').text());

                            } else {
                                teasers.push('No teaser available');
                            }
                        }
                    }
                    }
                });
            })();
            return [titles, hrefs, teasers];
            
        } else if (url === 'https://www.wsj.com/news/politics'
                  || url === 'https://www.wsj.com/news/technology') {
            
            var divclass = 'wsj-headline dj-sg wsj-card-feature heading-3 locked';

            var execute_ajax = (function(){
                $.ajax({
                async:false,
                type: "GET",
                url: yql,
                dataType: "xml",
                success: function (data) {
                    var nodes = data.getElementsByClassName(divclass);

                    for (l = 0; l < 10; l++){
                        
                        if (typeof(nodes[l]) !== 'undefined'){ //if there less than 10 'une'
                            hrefs.push(
                                $(nodes[l]).find('a').attr('href'));
                            titles.push(
                                $(nodes[l]).find('a').html());
                            
                            //console.log($(nodes[l]).nextAll());
                            
                            if ($(nodes[l]).nextAll().length === 1){ 
 
                                teasers.push(
                                    $(nodes[l]).nextAll('p.wsj-summary.dj-sg.wsj-card-feature').text());
                                
                            } else if ($(nodes[l]).siblings().length === 2){

                                teasers.push(
                                    $(nodes[l]).siblings('div.wsj-card-body.clearfix').children('p.wsj-summary.dj-sg.wsj-card-feature').text());
                                
                            } else {
                                teasers.push('No teaser available');
                            }
                        }
                    }
                    }
                });
            })();
            return [titles, hrefs, teasers];
        }
        
        
       
    //NYT 
    } else if (journal === 'New York Times'){

        //Each section of the NYT has its own scrapping method
        // WORLD & TECH    
        if (url === 'https://www.nytimes.com/section/technology'
              || url === 'https://www.nytimes.com/section/world'){
            
            divclass = 'story-body'
            
            var execute_ajax = (function(){
            $.ajax({
            async:false,
            type: "GET",
            url: yql,
            dataType: "xml",
            success: function (data) {
                var nodes = data.getElementsByClassName(divclass);
                
                for (l = 0; l < 10; l++){
    
                    if (typeof(nodes[l]) !== 'undefined'){
                        hrefs.push($(nodes[l]).children('div.thumb').children('a').text());
                        titles.push($(nodes[l]).children('h2.headline').text());
                        
                        if (typeof(nodes[l]) !== 'undefined'){ //if no teaser
                            teasers.push($(nodes[l]).children('p.summary').text());
                        } else {
                            teasers.push('No teaser available');
                        }
                    }
                }
                }
            });
        })();
        return [titles, hrefs, teasers];
        
        // DEALBOOK & ECO & ENERGY    
        } else if (url === 'http://www.nytimes.com/pages/business/dealbook/index.html?src=busfn'                    ||
                   url === 'http://www.nytimes.com/pages/business/economy/index.html?src=busfn'
                   ||
                   url === 'http://www.nytimes.com/pages/business/energy-environment/index.html?src=busfn'
                   ||
                   url === 'https://www.nytimes.com/pages/politics/index.html'){
            
            divclass = 'story'
            
            var execute_ajax = (function(){
            $.ajax({
            async:false,
            type: "GET",
            url: yql,
            dataType: "xml",
            success: function (data) {
                var nodes = data.getElementsByClassName(divclass);

                for (l = 0; l < 10; l++){
                    if (typeof(nodes[l]) !== 'undefined'){
                        hrefs.push($(nodes[l]).children('h3').children('a').attr('href'));
                        titles.push($(nodes[l]).children('h3').children('a').text()); 
                       
                        if (typeof(nodes[l]) !== 'undefined'){ //if no teaser
                            teasers.push($(nodes[l]).children('p').text());
                        } else {
                            teasers.push('No teaser available');
                        }
                    }
                }
                }
            });
        })();
        return [titles, hrefs, teasers];
        }
    
    //FT   
    } else if (journal === 'Financial Times'){
        
        //var classe = 'js-teaser-heading-link';
        var classe = 'o-teaser__heading js-teaser-heading';
        
        var execute_ajax = (function(){
            $.ajax({
            async:false,
            type: "GET",
            url: yql,
            dataType: "xml",
            success: function (data) {
                var nodes = data.getElementsByClassName(classe);
                
                for (l = 0; l < 10; l++){
                    //console.log($(nodes[l]).siblings('p.o-teaser__standfirst'));
                    if (typeof(nodes[l]) !== 'undefined'){
                        hrefs.push($(nodes[l]).children('a.js-teaser-heading-link').attr('href'));
                        titles.push($(nodes[l]).children('a.js-teaser-heading-link').text()); 
                       
                        if (typeof(nodes[l]) !== 'undefined'){ //if no teaser
                            teasers.push($(nodes[l]).siblings('p.o-teaser__standfirst').text());
                        } else {
                            teasers.push('No teaser available');
                        }
                    }
                }
                }
            });
        })();
        return [titles, hrefs, teasers];
        
    //Les Echos    
    } else if (journal === 'Les Echos'){

        var classe = 'titre';
        
        var execute_ajax = (function(){
            $.ajax({
            async:false,
            type: "GET",
            url: yql,
            dataType: "xml",
            success: function (data) {
                var nodes = data.getElementsByClassName(classe);
                
                for (l = 0; l < 10; l++){
                    //console.log($(nodes[l]).siblings('div.chapo-options').children());
                    console.log($(nodes[l]).siblings())
                    
                    if (typeof(nodes[l]) !== 'undefined'){
                        hrefs.push($(nodes[l]).children('a').attr('href'));
                        titles.push($(nodes[l]).children('a').text()); 
                       
                        if ($(nodes[l]).siblings().length === 2){ 
 
                                teasers.push(
                                    $(nodes[l]).siblings('div.chapo-options').children('p.chapo').text());
                                
                            } else if ($(nodes[l]).siblings().length === 3){

                                teasers.push(
                                    $(nodes[l]).siblings('p.chapo').text())
                                
                            } else {
                                teasers.push('No teaser available');
                            }

                    }
                }
                }
            });
        })();
        return [titles, hrefs, teasers];
    }
}



/*
function previous_onclick() {
    window.location.href = "index.html";
    }*/