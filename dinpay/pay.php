<? header("content-Type: text/html; charset=utf-8");?><style type="text/css">
<!--
body {
	background-color: #ffffff;
}
-->
</style>  
<form action="/dinpay/req.php" method="post" name="a32" target="_blank" >
<input name="p2_Order" type="hidden" value="<?=$_GET['p2_Order']?>" />
<input name="p3_Amt" type="hidden" value="<?=$_GET['p3_Amt']?>" />
<input name="pa_MP" type="hidden" value="<?=$_GET["pa_MP"]?>" />

 <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>       <div class="heng heng-w">
            <div class="aq-txt">充值金额：
            <SPAN style="font-size:12px;color:#ff0000;padding-top:6px"><?=$_GET['p3_Amt']?>元</SPAN>
            
           
        </div>

    <div class="heng heng-w">
            <div class="aq-txt">选择银行：</div>
            <div  ><table  border="0" cellpadding="5" cellspacing="6" bgcolor="#ffffff">
                            <tbody>
                                <tr>
                                    <td height="35" bgcolor="#ffffff">
                                        <input type="radio" name="issuerId" value="ICBC" class="banking" id="bank_icbc" 
                                            checked="checked" >
                                  <img src="bank/bank_icbc.gif" alt="icbc" width="107" height="20">                                    </td>
                                    <td height="35" bgcolor="#ffffff">
                                        <input type="radio" name="issuerId" value="ABC" class="banking" id="bank_abc" >
                                  <img src="bank/bank_abc.gif" alt="abc" width="107" height="20">                                    </td>
                                    <td height="35" bgcolor="#ffffff">
                                        <input type="radio" name="issuerId" value="BOC" class="banking" id="bank_boc" >
                                  <img src="bank/bank_boc.gif" alt="boc" width="107" height="20">                                    </td>
                                </tr>
                                <tr>
                                    <td height="35" bgcolor="#ffffff">
                                        <input type="radio" name="issuerId" value="BCOM" class="banking" id="bank_comm" >
                                  <img src="bank/bank_comm.gif" alt="comm" width="107" height="20">                                    </td>
                                    <td height="35" bgcolor="#ffffff">
                                        <input type="radio" name="issuerId" value="CMB" class="banking" id="bank_cmb" >
                                  <img src="bank/bank_cmb.gif" alt="cmb" width="107" height="20">                                    </td>
                                    <td height="35" bgcolor="#ffffff">
                                        <input type="radio" name="issuerId" value="SPDB" class="banking" id="bank_spdb" >
                                  <img src="bank/bank_spdb.gif" alt="spdb" width="107" height="20">                                    </td>
                                </tr>
                                <tr>
                                    <td height="35" bgcolor="#ffffff">
                                        <input type="radio" name="issuerId" value="CIB" class="banking" id="bank_cib" >
                                  <img src="bank/bank_cib.gif" alt="cib" width="107" height="20">                                    </td>
                                    <td height="35" bgcolor="#ffffff">
                                        <input type="radio" name="issuerId" value="CEB" class="banking" id="bank_ceb" >
                                  <img src="bank/bank_ceb.gif" alt="ceb" width="107" height="20">                                    </td>
                                  <td height="35" bgcolor="#ffffff"><input type="radio" name="issuerId" value="GDB" class="banking" id="bank_cgb">
                                  <img src="bank/bank_cgb.gif" alt="cgb" width="107" height="20" /> </td>
                                </tr>
                                <tr>
                                  <td height="35" bgcolor="#ffffff"><input type="radio" name="issuerId" value="ECITIC" class="banking" id="bank_citic">
                                  <img src="bank/bank_citic.gif" alt="citic" width="107" height="20" /> </td>
                                  <td height="35" bgcolor="#ffffff"><input type="radio" name="issuerId" value="CCB" class="banking" id="bank_ccb" />
                                    <img src="bank/bank_ccb.gif" alt="ccb" width="107" height="20" /></td>
                                  <td height="35" bgcolor="#ffffff"><input type="radio" name="issuerId" value="SPABANK" class="banking" id="radio" />
                                  <img src="bank/bank_pingan.gif" alt="psbc" width="107" height="20" /></td>
                                </tr>
                                <tr>
                                  <td height="35" bgcolor="#ffffff"><input type="radio" name="issuerId" value="HXB" class="banking" id="bank_citic">
                                  <img src="bank/bankhx.gif" alt="citic" width="107" height="22" /> </td>
                                  <td height="35" bgcolor="#ffffff"><input type="radio" name="issuerId" value="POST" class="banking" id="radio2" />
                                    <img src="bank/bank_psbc.gif" alt="psbc" width="107" height="20" /></td>
                                  <td height="35" bgcolor="#ffffff"><input type="radio" name="issuerId" value="CMBC" class="banking" id="bank_cmbc" />
                                    <img src="bank/bank_cmbc.gif" alt="cmbc" width="107" height="20" /></td>
                                </tr>
                        
                                <tr>
                                  <td height="35" bgcolor="#ffffff"><input type="radio" name="issuerId" value="SDB" class="banking" id="bank_hxb" />
                                  <img src="bank/bank_sdb.gif" alt="hxb" width="121" height="21" /></td>
                                  <td height="35" bgcolor="#ffffff"><input type="radio" name="issuerId" value="BEA" class="banking" id="radio3" />
                                    <img src="bank/bank_dy.gif" alt="psbc" width="107" height="20" /></td>
                                  <td height="35" bgcolor="#ffffff">&nbsp;</td>
                                </tr>
                            
                                <tr>
                                  <td height="35" bgcolor="#ffffff"><input name="Inputaa" type="submit" value="马上提交充值" /></td>
                                  <td height="35" bgcolor="#ffffff"><a href="htt;//www.baidu.com/" target="_blank"> </a></td>
                                  <td height="35" bgcolor="#ffffff">&nbsp;</td>
                                </tr>
                            </tbody>
      </table>
            </div>
            
      </div></td>
  </tr>
</table>
</form>
 	
		 