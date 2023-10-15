// A copy of some of the coded needed for the platform

// for the 4 different diagrams

function computeByDimensions(labels, lengths) {
  let scores = [];
  for (i = 0; i < labels.length; i++) { // which major dimension
    scores[i] = 0;
    for (j = 1; j <= lengths[i]; j++) { // which sub dimension
      const cname = labels[i].toLowerCase() + j;
      let x = +localStorage.getItem(cname);
      if (isNaN(x)) x = 0;
      x--;
      if (x < 1) x = 0;
      scores[i] += x;
    }
    if (isNaN(scores[i])) scores[i] = 0;
    scores[i] = Math.floor(scores[i] * 100 / (lengths[i] * 3));
  }
  return scores;
}

function computeScores(labels) {
  let scores = [];
  for (i = 0; i < labels.length; i++) {
    x = localStorage.getItem(labels[i].toLowerCase());
    if (isNaN(x)) x = 0; x--; if (x < 1) x = 0;
    scores[i] = Math.floor((100 * x)/3);
  }
  return scores;
}

function putToc(){ // x is the title of the first entry
  s=`<a class=wide onclick="goto(1);">${basics['h1']}</a>
  `;
// this correspond to the first page in each category
  const whichp=[2,8,10,15,18,20,24,25,28];
	for(i=0;i<9;i++) { // put the 9 full-width buttons
      s+=`<a class="wide" onclick="goto(${whichp[i]});"}>${dimensions[i]}</a>
      `;
	}
  document.getElementById("main").innerHTML=s;
}
// note -- p numbers lengths and formulas are entirely different in the community version
function putResults(p) {
  let scores = []; let labels = []; let tags = [];
  if (p == 32) {
    const lengths = [6, 2, 5, 3, 2, 4, 1, 3, 4]; // number of sub-elements in each
    labels = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I']; // uppercase version of labels
    scores = computeByDimensions(labels, lengths);
    spider(scores, labels);
    putDimensionScores(scores, labels);
  } else if (p == 33) {
    labels = ['A1', 'A2', 'A3', 'A4', 'A5', 'A6'];
    tags = ['p2', 'p3', 'p4', 'p5', 'p6', 'p7'];
    scores = computeScores(labels);
    spider(scores, labels);
    putRubricScores(scores, tags);
  } else if (p == 34) {
    labels = ['B1', 'B2', 'C1', 'C2', 'C3', 'C4', 'C5'];
    tags = ['p8', 'p9','p10', 'p11', 'p12', 'p13', 'p14'];
    scores = computeScores(labels);
    spider(scores, labels);
    putRubricScores(scores, tags);
  } else if (p == 35) {
    labels = ['D1', 'D2', 'D3', 'E1', 'E2', 'F1', 'F2', 'F3', 'F4', 'G1'];
    tags = [ 'p15', 'p16','p17','p18','p19','p20','p21','p22','p23','p24'];
    scores = computeScores(labels);
    spider(scores, labels);
    putRubricScores(scores, tags);
  } else {
    labels = ['H1', 'H2', 'H3', 'I1', 'I2', 'I3', 'I4'];
    tags = ['p25', 'p26', 'p27', 'p28', 'p29', 'p30', 'p31'];
    scores = computeScores(labels);
    spider(scores, labels);
    putRubricScores(scores, tags);
  }
}

function putDimensionScores(scores) { // table of scores with dimension labels
  let t = "<center>\n<table>\n";
  for (i = 0; i < scores.length; i++) {
    t += "<tr><td>" + scores[i] + "</td><td>";
    t += dimensions[i] + "</td></tr>\n";
  }
  s += t + "</table>\n</center>";
}

function putRubricScores(scores, tags) {
  let t = "<center>\n<table>\n";
  for (i = 0; i < scores.length; i++) {
    t += "<tr><td>" + scores[i] + "</td><td>";
    t += rubric[tags[i]][0] + "</td></tr>\n";
  }
  s += t + "</table>\n</center>";
}

function spider(data, labels) {
  n = data.length;
  s+='<svg viewBox="0 0 240 240" xmlns="http://www.w3.org/2000/svg">';
  s+='<style> .n {font: 10px sans-serif; fill: black;}</style>';
  for (r = 10; r < 110; r = r + 10) { // first layout the grid
    y = 120 - r;
    s+='<text class="n" x="121" y="' + y + '">' + r + '</text>';
    s+='<polygon points="';
    for (i = 0; i < n; i++) { putXY(r, i, n); }
    s+='" fill="none" stroke="blue" /></polygon>';
  }
  // Next draw the data points
  s+='<polygon points="';
  for (i = 0; i < n; i++) putXY(data[i], i, n);
  s+='" fill="rgba(0,255,0,0.3)" stroke="darkgreen"></polygon>';
  // Next put the labels in the appropriate points
  for (i = 0; i < n; i++) {
    a = (2 * Math.PI * i) / n;
    x = Math.floor(115 + 105 * Math.sin(a));
    y = Math.floor(125 - 105 * Math.cos(a));
    s+='<text class="n" x="' + x + '" y="' + y + '">' + labels[i] + '</text>';
  }
  s+="</svg>";
}
// Main page contents script -- using global p variable

function putPages() {
	localStorage.setItem('pointer',p);
// This is only relevant if there are government page, not included in the community version 
//  const govs=["11","12","13","14","15","22"];
// routing to different style english pages
	if(page==0) {
		putToc();
} else if(page==1){
	putBasics();
//} else if(localStorage.getItem("orgtype")=='0' && govs.indexOf(p)>-1) {
//	putRubric(rubric['g'+p]);
//  handle the non-graph pages
} else if(page<(maxpage-4)) {
	putRubric(rubric['p'+page]);
} else {
	const n=page-(maxpage-5);
	s='<h2>'+basics["figure1"]+n+basics["figure2"]+'</h2>';
	putResults(page); // spider diagrams
	document.getElementById("main").innerHTML=s;
}


}


// ADMIN Functions
function putMailButton(){
  let msg="Email the data";
  if(lang=='fr') msg='Envoyer les données par e-mail';
  if(lang=='es') msg='Enviar datos por correo electrónico';
  const text=JSON.stringify(localStorage);
  const href1="mailto:admin@mcld.org?subject=MCLD+Data&body=";
  const button="<a class=wide href="+href1+encodeURI(text)+">"+msg+"</a>";
  document.getElementById("mailbutton").innerHTML=button;
}
function download(filename, text) {
  var element = document.createElement('a');
  element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
  element.setAttribute('download', filename);
  element.style.display = 'none';
  document.body.appendChild(element);
  element.click();
  document.body.removeChild(element);
}

function downloadStorage() {
  const filename = localStorage.getItem("date") + localStorage.getItem("organization") + '.json';
  const text = JSON.stringify(localStorage);
  download(filename,text);
}

function convert2Storage(){
  document.cookie.split('; ').reduce((prev, current) => {
    const [name, value] = current.split('=');
    localStorage.setItem(name,decodeURI(value));
  }, {});
}

function clearStorage() {
  localStorage.clear();
  alert("OK, data cleared");
}
