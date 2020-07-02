<?php
/*
Template Name:Generate Contract
*/
namespace Dompdf;
require_once 'dompdf/autoload.inc.php';
ob_start();
?>
<div class="row contract-detail-formsection">
   <div class="col-md-12">
      <h3>Form Details</h3>
      <div class="pdf-wrapper" style="padding: 50px 50px;">
         <table style="width:100%;">
            <tbody>
               <tr>
                  <td colspan="2">
                     <table style="width:100%;">
                        <tbody>
                           <tr>
                              <td colspan="2">
                                 <table style="width:100%;">
                                    <tbody>
                                       <tr>
                                          <td style="width:40%;">
                                             <img src="https://nycrooms.midriffdevelopers.live/wp-content/uploads/2020/06/logo.png" style="width:250px;">
                                          </td>
                                          <td style="width:60%;padding: 0 0px 0 10%;">
                                             <h2 style="text-align: right;margin-top: 0;margin-bottom: 0;">Apartment Sharing Contract</h2>
                                             <table style="width:100%;margin-top:10px;border:1px solid #000;">
                                                <tbody>
                                                   <tr>
                                                     
                                                   </tr>
                                                </tbody>
                                             </table>
                                          </td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                 
                     <table style="width:100%;margin-top:35px;">
                        <tbody>
                           <tr>
                              <td style="padding: 0 0 10px 0;width:100%;">
                                 <p style="color: #333;margin: 0px;font-size:20px;font-weight: 600;text-transform: capitalize;">(1)Customer Seeks Information Regarding Shared Living Accomodations With The Following:</p>
                              </td>
                           </tr>
                           <tr>
                              <td colspan="2">
                                 
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  
                     
                     <!-- Wrapper / End -->
                  </td>
               </tr>
            </tbody>
         </table>
         </td></tr></tbody></table>
        
        
         </td>
         </tr>
         </tbody>
         </table>
        
        
      </div>
   </div>
</div>

<?php
$html = ob_get_clean();
$dompdf = new DOMPDF();
$dompdf->setPaper('A4', 'landscape');
$dompdf->load_html($html);
$dompdf->render();
//For view
$dompdf->stream("",array("Attachment" => false));
// for download
//$dompdf->stream("sample.pdf");
?>