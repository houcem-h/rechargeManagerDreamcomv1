<?php
/*require('html2pdf.class.php');*/
require_once('../../vendor/autoload.php');
require('class/recharge.class.php');

try{

    ob_start();?>
    <?php

        $ticket = new Recharge();
        $sql = 'SELECT * FROM recharge order by nserie asc limit ';
        $qte = $_POST["qte"];
        $sql .= $qte;
        $reponse=$ticket->execReq($sql);
        $reponse->execute();
        $content = '';
        while($data=$reponse->fetch()){
            ?>
            <page>
                <table style="max-width=47mm">
                    <tr>
                        <td><h3>Orange Tunisie</h3></td>
                    </tr>
                    <tr style="font-weight: bold;">
                        <td>Recharge de : <?php echo $data["vlr"]; ?> DT</td>
                    </tr>
                    <tr>
                       <td>Code de recharge :</td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">
                            <h3><?php echo $data["code"]; ?></h3>
                        </td>
                    </tr>
                    <tr><td>Méthode de recharge :</td></tr>
                    <tr><td>composez *100*code de recharge#</td></tr>
                    <tr>
                        <td style="text-align:right;">N° Serie: <?php echo $data["nserie"]; ?></td>
                    </tr>
                    <tr style="font-weight: bold;">
                        <td style="text-align:center;">www.dreamcom.tn</td>
                    </tr>

                </table>
            </page>
            <?php
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
        }
            $contenu = ob_get_clean();
            $pdf = new html2pdf('P','A8','fr',true,'UTF-8');
            $pdf->writeHTMl($contenu);


            //générer un nom unique
            $date = getdate();
            $nom = $date[0].'.pdf';
            $pdf->Output($nom);
            }
                catch(HTML2PDF_exception $e) {
                    echo $e;
                    exit;
                }



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
