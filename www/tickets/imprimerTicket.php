<?php
/*require('html2pdf.class.php');*/
require_once('../../vendor/autoload.php');
require('class/tickets.class.php');

try{

    ob_start();?>
    <?php

        $ticket = new Tickets();
        $impression = $ticket->affichTicketSpecifiq($_GET['id_impress']);
        while ($donnee = $impression->fetch()) {
          $agent = $donnee['idAgent'];
          $dateImpress = $donnee['dateImpression'];
        }
        $ticket->modifEtatTicket($_GET['id_impress']);
        $reponse = $ticket->imprimerTicketAgent($_GET['id_impress']);
        while($data=$reponse->fetch()){
            ?>

            <page style="font-size: 9pt;width: 100%;">
                <table>
                  <tr>
                    <td>-----------------------------------------------</td>
                  </tr>
                    <tr style="text-align:center;max-width=58mm">
                        <td style="font-weight: bold;font-size: 10pt;">Orange Tunisie</td>
                    </tr>
                    <tr style="font-weight: bold;">
                        <td>Recharge de : <?php echo $data["vlr"]; ?> DT</td>
                    </tr>
                    <tr style="font-size: 7pt;">
                      <td>Code impression : <?php echo $_GET['id_impress']; ?></td>
                    </tr>
                    <tr style="font-size: 7pt;">
                      <td>Agent : <?php echo $agent; ?></td>
                    </tr>
                    <tr style="font-size: 7pt;">
                      <td>Date : <?php echo $dateImpress; ?></td>
                    </tr>
                    <tr>
                       <td>Code de recharge :</td>
                    </tr>
                    <tr style="font-weight: bold;font-size: 12pt;">
                        <td style="text-align:center;max-width=58mm">
                            <?php echo $data["code"]; ?>
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
            $pdf = new html2pdf('L','A9','fr',true,'UTF-8',array(0, 1, 1, 1));
            $pdf->writeHTMl($contenu);
            $nom = $_GET['id_impress'].'.pdf';
            $pdf->Output($nom);
            sleep(2);
            header('Location:gererTickets');
            }
                catch(HTML2PDF_exception $e) {
                    echo $e;
                    exit;
                }
                ?>
