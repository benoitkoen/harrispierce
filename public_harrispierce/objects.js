// topiclist contains all topic objects created
var journalList = [];
var sectionList = [];

// topic is an object that has a topicname and a list of words
var journal = {
    init : function(journalName, sectionUrls) {
        this.journalName = journalName;
        this.sectionUrls = sectionUrls
    }

};



var WSJ = Object.create(journal);
var WSJUrls = {
    World: "https://www.wsj.com/news/world", 
    Economy: "https://www.wsj.com/news/economy",
    Companies: "https://www.wsj.com/news/business", 
    Politics: "https://www.wsj.com/news/politics",
    Tech: "https://www.wsj.com/news/technology",
    Opinion: "https://www.wsj.com/news/opinion",   
};
WSJ.init('Wall Street Journal', WSJUrls);
journalList.push(WSJ);


var NYT = Object.create(journal);
var NYTUrls = {
    World: "https://www.nytimes.com/section/world", 
    Economy: "http://www.nytimes.com/pages/business/economy/index.html?src=busfn", 
    Dealbook: "http://www.nytimes.com/pages/business/dealbook/index.html?src=busfn",
    Politics: "https://www.nytimes.com/pages/politics/index.html",
    Tech: "https://www.nytimes.com/section/technology",
    Energy: "http://www.nytimes.com/pages/business/energy-environment/index.html?src=busfn", 
};
NYT.init('New York Times', NYTUrls);
journalList.push(NYT);


var FT = Object.create(journal);
var FTUrls = {
    World: "http://ft.com/world", 
    Companies: "http://ft.com/companies",
    Markets: "http://ft.com/markets", 
    Opinion: "https://www.ft.com/opinion", 
    Careers: "https://www.ft.com/work-careers"  
};
FT.init('Financial Times', FTUrls);//(Subscription needed!)
journalList.push(FT);


var lesEchos = Object.create(journal);
var lesEchosUrls = { 
    World: "http://www.lesechos.fr/monde/index.php", 
    Economy: "http://www.lesechos.fr/economie-france/index.php",
    Markets: "http://www.lesechos.fr/finance-marches/index.php",
    Politics: "http://www.lesechos.fr/politique-societe/index.php",
    Tech: "http://www.lesechos.fr/tech-medias/index.php", 
};
lesEchos.init('Les Echos', lesEchosUrls);
journalList.push(lesEchos);



for (i=0; i < journalList.length; i++){
        var journal = journalList[i];
        for (j in Object.keys(journal.sectionUrls)){
            var section = Object.keys(journal.sectionUrls)[j];
            if (sectionList.indexOf(section) === -1){
                sectionList.push(section);
            }
        }
}


function sortJournals() {
    var sortedJournals = journalList.sort(function(a, b) { 
        return Object.keys(b.sectionUrls).length - Object.keys(a.sectionUrls).length;
    })
    return(sortedJournals);
}

var sections = {};
function sortSections() {
    for (i=0; i < journalList.length; i++){
        var journal = journalList[i];
        for (j in Object.keys(journal.sectionUrls)){
            var section = Object.keys(journal.sectionUrls)[j];
            if (sections.hasOwnProperty(section)){
                sections[section].push(journal.journalName);
            } else {
                sections[section] = [journal.journalName];
            }
        }
    }
    sortedSections = Object.keys(sections).sort(function(a,b){return sections[b].length - sections[a].length});
    return sortedSections;
}


var sortedJournals = sortJournals();//journalList;
var sortedSections = sortSections();

























