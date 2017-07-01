function calculTotalLigne1() {
    var qte1 = document.getElementById('qte1').value;
    var vlr1 = document.getElementById('vlr1').value;
    var totalLigne1 = parseInt(vlr1) * parseInt(qte1);
    document.getElementById('totalLigne1').value = totalLigne1.toString();
    var totalcommande = parseInt(document.getElementById('totalcommande').value);
    totalcommande+=totalLigne1;
    document.getElementById('totalcommande').value = totalcommande.toString();
}
function calculTotalLigne2() {
    var qte2 = document.getElementById('qte2').value;
    var vlr2 = document.getElementById('vlr2').value;
    var totalLigne2 = parseInt(vlr2) * parseInt(qte2);
    document.getElementById('totalLigne2').value = totalLigne2.toString();
    var totalcommande = parseInt(document.getElementById('totalcommande').value);
    totalcommande+=totalLigne2;
    document.getElementById('totalcommande').value = totalcommande.toString();
}
function calculTotalLigne3() {
    var qte3 = document.getElementById('qte3').value;
    var vlr3 = document.getElementById('vlr3').value;
    var totalLigne3 = parseInt(vlr3) * parseInt(qte3);
    document.getElementById('totalLigne3').value = totalLigne3.toString();
    var totalcommande = parseInt(document.getElementById('totalcommande').value);
    totalcommande+=totalLigne3;
    document.getElementById('totalcommande').value = totalcommande.toString();
}
