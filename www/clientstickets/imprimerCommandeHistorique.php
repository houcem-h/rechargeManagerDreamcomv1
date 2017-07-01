<?php
require_once('../../vendor/autoload.php');
require_once('class/commandes.class.php');

try{

    ob_start();?>
    <?php

        $ticket = new Commande();
        $commande = $ticket->affichCommandeSpecifiq($_GET['id_comm']);
        while ($donnee = $commande->fetch()) {
          $client = $donnee['idClient'];
          $dateComm = $donnee['dateComm'];
        }
        $reponse = $ticket->imprimerCommandeClientHistorique($_GET['id_comm']);
        while($data=$reponse->fetch()){
            ?>

            <page style="font-size: 9pt;width: 100%;">
              <page_header>
                ---------------------------------------------
              </page_header>
                <table>
                    <tr style="text-align:center;max-width=58mm">
                        <td><h4>Orange Tunisie</h4></td>
                    </tr>
                    <tr style="font-weight: bold;">
                        <td>Recharge de : <?php echo $data["valeur"]; ?> DT</td>
                    </tr>
                    <tr style="font-size: 7pt;">
                      <td>Facture N° : <?php echo $_GET['id_comm']; ?></td>
                    </tr>
                    <tr style="font-size: 7pt;">
                      <td>Client : <?php echo $client; ?></td>
                    </tr>
                    <tr style="font-size: 7pt;">
                      <td>Date : <?php echo $dateComm; ?></td>
                    </tr>
                    <tr>
                       <td>Code de recharge :</td>
                    </tr>
                    <tr>
                        <td style="text-align:center;max-width=58mm">
                            <h3><?php echo $data["code"]; ?></h3>
                        </td>
                    </tr>
                    <tr style="font-size: 7pt;"><td>Méthode de recharge :</td></tr>
                    <tr style="font-size: 7pt;"><td>composez *100*code de recharge#</td></tr>
                    <tr text-align:center;>
                        <td>N° Serie: <?php echo $data["nserie"]; ?></td>
                    </tr>
                    <tr style="text-align:center;font-size: 6pt;">
                      <td>Droits de timbre de 10% seront ajoutés à la recharge<br> (loi des finances 2014)</td>
                    </tr>
                    <!-- <tr style="font-weight: bold;">
                        <td style="text-align:center;">www.dreamcom.tn</td>
                    </tr> -->

                </table>
            </page>
            <?php

        }
            $contenu = ob_get_clean();
            $pdf = new html2pdf('P','A8','fr',true,'UTF-8',array(0, 1, 1, 1));
            $pdf->writeHTMl($contenu);
            $nom = $_GET['id_comm'].'.pdf';
            $pdf->Output($nom);
            $ticket->modifEtatCommande($_GET['id_comm']);
            header ("Location:homeclient");
            }
                catch(HTML2PDF_exception $e) {
                    echo $e;
                    exit;
                }
                /*$qte = $_POST["qte"];
                    $req = 'SELECT * FROM recharge order by nserie asc limit ';
                    $req .= $qte;
                    $reponse=$bdR->query($req);
                $content = '';
                $pdf = new html2pdf('P','A8','fr',true,'UTF-8');
                while($data=$reponse->fetch()){
                $content= "
                <page>
                    <h2>Orange Tunisie</h2>
                    <h2>Recharge de ".$data["vlr"]." DT</h2>
                    N° SERIE: <i>".$data["nserie"]."</i><br>
                    <p>Code de recharge</p>
                    <b>".$data["code"]."</b>
                    <a href='http://dreamcom.tn'>Dreamcom.tn</a><br>
                    </page>";
                    $pdf->writeHTMl($content);
                }*/


//utilisation de FPDF
//-----------------------------
/*class PDF extends FPDF
{
// Page header
function Header()
{
    // Arial bold 15
    $this->SetFont('Arial','B',6);
    // Move to the right
    $this->Cell(80);
    // Title
    $this->Cell(30,10,'Title',1,0,'C');
    // Line break
    $this->Ln(20);
}*/


/*if (!empty($_POST)){
    $qte = $_POST["qte"];
    $req = 'SELECT * FROM recharge order by nserie asc limit ';
    $req .= $qte;
    $reponse=$bdR->query($req);
    $affich ='';
    $pdf = new FPDF('P','mm','A8');
    $pdf->SetFont('Arial','B',6);
    $pdf->AddPage();
    while($data=$reponse->fetch()){
            $affich=$data["nserie"].$pdf->Ln().$data["code"].$pdf->Ln().$data["vlr"].$pdf->Ln().$data["dateExp"];
            $pdf->Cell(4,1,$affich);
    }
    $pdf->Output();
}*/
?>
