<?php
/*
Plugin Name: Baufinanzierung Zinstableau
Plugin URI: http://www.interhyp.de/
Description: Dieses Widget liest die aktuellen Baufinanzierungs-Zinskonditionen (effektiv und nominal) &uuml;ber eine XML-Schnittstelle von der Webseite Interhyp.de und gibt diese in einer Tabelle aus. 
Author: Jan Gehrke
Version: 1
Author URI: http://www.interhyp.de/
*/
 
function zinstableau_widget() {
	// XML-Daten einlesen
				$datei="http://www.interhyp.de/interhyp-topzinsen.xml";
				$fp=fopen($datei,"r");
				$xml=fread($fp,1024);
				fclose($fp);
				// XML-Baum abbilden
				$tree=xmltree($xml);
				// XML-Inhalte auslesen
				$date=$tree->children[0]->children[1]->children[0]->content;
				$nom5=$tree->children[0]->children[3]->children[0]->content;
				$eff5=$tree->children[0]->children[5]->children[0]->content;
				$nom10=$tree->children[0]->children[7]->children[0]->content;
				$eff10=$tree->children[0]->children[9]->children[0]->content;
				$nom15=$tree->children[0]->children[11]->children[0]->content;
				$eff15=$tree->children[0]->children[13]->children[0]->content;
				$nom20=$tree->children[0]->children[15]->children[0]->content;
				$eff20=$tree->children[0]->children[17]->children[0]->content;
				$nom25=$tree->children[0]->children[19]->children[0]->content;
				$eff25=$tree->children[0]->children[21]->children[0]->content;
?>
	<script type="text/javascript" src="http://www.interhyp.de/script/quickcheck.js"></script>
  <script language="JavaScript" type="text/javascript" src="http://www.interhyp.de/script/wz_dragdrop.js"></script>
  <script language="JavaScript" type="text/javascript" src="http://www.interhyp.de/script/schieber_box.js"></script>


		<style>
				table.zinsbox, a.zinsTable{
				  width: 175px;
				  display: block;
				}
				table.zinsbox tbody{
				  width: 100%;

				}
				a.zinsTable{
					background: none;
					cursor: hand;
					position: absolute;
					z-index: 99;
					text-decoration: none;
					height: 85px;
				}
				table.zinsbox{
				  border: 1px solid #808080;
				  border-collapse:collapse;
				  padding-top: 0px;
				}
				tr.dark, tr.dark a, tr.dark a:link, tr.dark a:visited{
				  background-color: #f4f4f4;
				  color: #333333;
				  width: 100%;
				}
				tr.bright, tr.bright a, tr.bright a:link, tr.bright a:visited{
				  color: #606060;
				  background-color: #ffffff;
				  width: 100%;
				}
				td.zinsbox, a.zinsbox{
				  font-size: 10px;
				  line-height: 12px;
				  text-decoration: none;
				  padding: 1px 2px 1px 2px;
				  margin: 0px;
				  width: 100%;
				  cursor: pointer;
				}
				/*
				  Slider
				*/
				.sliderParent {
				  font-size: 11px;
				  float:left;
				  overflow:hidden;
				  margin: 8px 0px 0px 0px;
				  padding-left: 7px;
				  width: 487px;
				  }
				.sliderParent h3{
				  margin-top: 0px;
				  margin-bottom: 5px;
				  color: #333333;
				  font-size: 12px;
				  font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
				}
				/*
				  Schieber
				*/
				#burden_thumb, #equity_thumb, #amort_thumb, #maturity_thumb, #diff_thumb, #amount_thumb{
				  width: 8px;
				  height: 23px;
				  position: relative;
				  top: -14px;
				  left: -3px;
				  z-index: 101;
				}
				
				div.schieber{
				  position: relative;
				  height: 38px;
				  padding-top: 10px;
				  margin-top: 6px;
				}
				
				div.sliderSchieber{
				  position: relative;
				  height: 25px;
				  line-height: 10px;
				}
				
				span#loan_value{
				  border-bottom: 2px solid #f0732d;
				}
				
				div.resLoan{
				  font-size: 14px;
				  color: #f0732d;
				  font-weight: bold;
				  line-height: 14px;
				  padding-bottom: 3px;
				  display: block;
				  position: relative;
				}
				
				div.sidebar div.resLoan{
					font-size: 14px;
					letter-spacing: -1px;
				  padding-bottom: 8px;
				}
				
				div.valueLabel{
				  font-size: 10px;
				  font-weight: bold;
				  position: absolute;
				  top: 26px;
				  border: 1px solid #f0732d;
				  text-align: center;
				  z-index: 2;
				  padding: 0px 5px 0px 5px;
				  background-color: white;
				}
				
				table.rechner td div.valueLabel{
				  top: 17px;
				}
				
				div.track{
				  height: 4px; 
				  display: block;
				  overflow: hidden;
				  position: relative;
					background: gray url(//www.interhyp.de/images/css_refer/track-bg.png) repeat-x 0px 0px;
					border: 1px solid #aeaeae;
					
				}
				
				div.track_fill{
					height: 4px;
					display: block;
					background: gray url(//www.interhyp.de/images/css_refer/track-bg.png) repeat-x 0px -10px;
				}
				
				div.marginLeft{
				  position: absolute;
				  top: 18px;
				  z-index: 1;
				  font-size: 10px;
				  color: black;
				}
				
				div.marginRight{
				  position: absolute;
				  top: 18px;
				  right: 4px;
				  z-index: 1;
				  font-size: 10px;
				  color: black;
				}
				
				div.schieberLabel{
				  font-size: 10px;
				  letter-spacing: normal;
				  line-height: 30px;
				  color: #606060;
				  font-weight: normal;
				  display: block;
				  margin: 0px 0px 5px 0px;
				  position: absolute;
				  top: 8px;
				  right: 0px;
				  left: 0px;
				}
				
				div.sidebar div.schieberLabel{
				  top: 4px;
				}
				
				
				div.sliderValueLabel{
				  font-size: 10px;
				  font-weight: bold;
				  position: absolute;
				  top: 10px;
				  border: 1px solid #f0732d;
				  text-align: center;
				  z-index: 2;
				  padding: 2px 5px 2px 5px;
				  background-color: #ffffff;
				}
				
				div.hint{
					font-size: 10px;
					line-height: 14px;
					background: none;
					position: absolute;
					z-index:103;
					top: 350px;
					left: 400px;
					right: 0px;
					bottom: 400px;
					width: 300px;
					display: none;
				}
				
				div.hint div.boxcontent_rechner{
					padding: 4px 8px 4px 8px;
				}
				
				div.hint div.boxcontent_rechner p{
					margin: 4px 0px 4px 0px;
				}
				/* Relativer Tooltip */
				a.tooltip, a.tooltip:link, a.tooltip:visited, a.tooltip:active  {
				  position: relative;
				  }
				  
				a.tooltip span {
				  display: none;  
				  text-decoration: none; 
				}
				
				a.tooltip:hover span {
				  display: block;
				  position: absolute; 
				  top: -150px; 
				  left:0; 
				  width: 220px;
				  z-index: 1000;
				  padding: 5px;
				  color: #202020; 
				  border:1px solid #000000; 
				  background: #FFFFFF;
				  font: 9px Verdana, sans-serif; 
				  line-height:15px;
				  text-align: left;
				  }
				
				  
				a.tooltip span b {
				  display: block;
				  z-index: 1000;
				  margin: -5px;
				  padding: 5px;
				  font-size: 12px;
				  font-weigth: bold;
				  color: white;
				  background-color: #F0732D;
				  border: 0px;
				  border-bottom: 1px solid black;
				}


		</style>
	<div style="position: relative;">
		<h2>Baufinanzierung</h2>
		<a class="zinsTable" href="http://www.interhyp.de/interhyp/servlet/interhyp?view=webKonditionen&STYLE=b2c">&nbsp;</a>

			<table class="zinsbox" onClick="parent.location='http://www.interhyp.de/interhyp/servlet/interhyp?view=webKonditionen&STYLE=b2c'">
				<tr class="bright">
				<td class="zinsbox">&nbsp;</td>
				<td class="zinsbox">nominal</td>
				<td class="zinsbox">effektiv</td>
				</tr>
				<tr class="dark">
				<td class="zinsbox">5&nbsp;Jahre&nbsp;</td>
				<td class="zinsbox"><?=$nom5?>&nbsp;%</td>
				<td class="zinsbox"><?=$eff5?>&nbsp;%</td>
				</tr>
				<tr class="bright">
				<td class="zinsbox">10&nbsp;Jahre&nbsp;</td>
				<td class="zinsbox"><?=$nom10?>&nbsp;%</td>
				<td class="zinsbox"><?=$eff10?>&nbsp;%</td>
				</tr>
				<tr class="dark">
				<td class="zinsbox">15&nbsp;Jahre&nbsp;</td>
				<td class="zinsbox"><?=$nom15?>&nbsp;%</td>
				<td class="zinsbox"><?=$eff15?>&nbsp;%</td>
				</tr>
				<tr class="bright">
				<td class="zinsbox"> 20&nbsp;Jahre&nbsp;</td>
				<td class="zinsbox"><?=$nom20?>&nbsp;%</td>
				<td class="zinsbox"><?=$eff20?>&nbsp;%</td>
				</tr>
				<tr class="dark">
				<td class="zinsbox">25&nbsp;Jahre&nbsp;</td>
				<td class="zinsbox"><?=$nom25?>&nbsp;%</td>
				<td class="zinsbox"><?=$eff25?>&nbsp;%</td>
				</tr>
			</table>
		</div>
		
		<div style="font-size: 10px;">Stand: <?=$date?><br>
			<div><a class="tooltip" href="#">Annahmen<span><b>Annahmen</b>
				<p>
					Bei Interhyp gibt es keine Standardkonditionen. Denn wir besorgen f&uuml;r jeden Kunden das individuell beste Angebot, das der Markt hergibt. Unsere Topzinsen sind somit lediglich ein Ausschnitt dessen, was Sie bei uns bekommen k&ouml;nnen. 
				</p>
				<p>
					Sie basieren auf den folgenden Eckdaten: 200.000 Euro Darlehenssumme f&uuml;r den Kauf einer Immobilie, nachhaltiger Objektwert von mindestens 450.000 Euro, 1% Tilgung, keine Sondertilgung, Eigennutzung der Immobilie, erstrangige Absicherung des Darlehens &uuml;ber eine Grundschuld, einwandfreie Einkommens- und Verm&ouml;genssituation, gesichertes Angestelltenverh&auml;ltnis, Auszahlung des Darlehens in einer Summe.
				</p>
				<p>
					Bitte beachten Sie, dass die Kondition regional sowohl von der Postleitzahl des Finanzierungsobjektes und/oder des Wohnortes des Antragstellers abh&auml;ngig ist.
				</p>
		</a>
			</div>
		</div>
	<div>
<h3>Wie viel kann ich finanzieren?</h3>
		<form name="schieber">
			<div style="width: 175px;">
		
				<div>Monatliche Rate 
					
						<div class="schieber">
							<div class="track track_start">
								<div class="track_fill track_fill_start"	id="track_fill"></div>
							</div>
							<div class="marginLeft" id="marginLeft">0&nbsp;&euro;</div>
							<div class="marginRight">2.000&nbsp;&euro;</div>
							<img src="http://www.interhyp.de/images/css_refer/track-thumb.png" name="burden_thumb" id="burden_thumb">
							<div id="burden_value" class="valueLabel">1000&nbsp;&euro;</div>
						</div>
						<div class="resLoan" style="padding-top: 4px; margin-bottom: 20px; *margin-bottom/**/:/**/21px;">=&nbsp;<span id="loan_value">&nbsp;&euro;</span>
							<div class="schieberLabel"><p>M&ouml;gliches Darlehen</p></div>
	  				</div>
	  	  </div>
	  </form>
		  <script language=javascript>
			SET_DHTML ("burden_thumb"+NO_ALT+HORIZONTAL+CURSOR_E_RESIZE);
		  var amortisation = 1;
		  var f0 = new Formatter ("\#.\#\#\#");
		  var f2 = new Formatter ("\#.\#\#\#,00");
		  var rate = "3,10";
		  rate = rate.replace(/[,]/,'.');
		  rate = parseFloat(rate)
		  var burdenMin = 0;
		  var burdenMax = 2000;
		  var burden = 1000;
		  //initSchieber();
		  dd.elements.burden_thumb.maxoffl = 0;
	   	dd.elements.burden_thumb.maxoffr = 175;
		  setSchieber();
		  </script>
		</div>
		<div style="font-size: 10px;">Stand: <?=$date?>
			<div><a class="tooltip" href="#">Annahmen<span><b>Annahmen</b>
					<p>
						Bei Interhyp gibt es keine Standardkonditionen. Denn wir besorgen f&uuml;r jeden Kunden das individuell beste Angebot, das der Markt hergibt. Unsere Topzinsen sind somit lediglich ein Ausschnitt dessen, was Sie bei uns bekommen k&ouml;nnen. 
						</p>
						<p>Sie basieren auf den folgenden Eckdaten: 200.000 Euro Darlehenssumme f&uuml;r den Kauf einer Immobilie, nachhaltiger Objektwert von mindestens 450.000 Euro, 1% Tilgung, keine Sondertilgung, Eigennutzung der Immobilie, erstrangige Absicherung des Darlehens &uuml;ber eine Grundschuld, einwandfreie Einkommens- und Verm&ouml;genssituation, gesichertes Angestelltenverh&auml;ltnis, Auszahlung des Darlehens in einer Summe.
					</p>
					<p>
						Bitte beachten Sie, dass die Kondition regional sowohl von der Postleitzahl des Finanzierungsobjektes und/oder des Wohnortes des Antragstellers abh&auml;ngig ist.
					</p></a>
			</div>
		<div><p>Bereitgestellt durch Interhyp AG<br>Vermittlung von <a href="http://www.interhyp.de/"  title="Baufinanzierung" target="_blank">Baufinanzierung</a>.</p></div>
		</div>
			
<?php 

}
 
function init_zinstableau(){
    register_sidebar_widget("Baufinanzierung Zinstableau", "zinstableau_widget");     
}
			//Beginn Optionen für Backend
			$fb_meta_field = get_option('fb_meta_field');
			
			if ('insert' == $HTTP_POST_VARS['action'])
			{
			    update_option("fb_meta_field",$HTTP_POST_VARS['fb_meta_field']);
			}
			
			// Innerhalb von the_loop reicht das
			function fb_meta_description() {
			  global $id, $post_meta_cache, $fb_meta_field; // globale Variablen
			
			  if ( $keys = get_post_custom_keys() ) {
			    foreach ( $keys as $key ) {
			      $values = array_map('trim', get_post_custom_values($key));
			      $value = implode($values,', ');
			      if ( $key == $fb_meta_field ) {
			        echo "$value";
			      }
			    }
			  }
			} // Ende Funktion fb_meta_description()
			
			function fb_meta_description_option_page() {
			?>	
				<!-- Start Optionen im Adminbereich -->
			    <div class="wrap">
			      <h2>Plugin: Baufinanzierung Zinstableau - Optionen</h2>
			      <p>Backlink zur Interhyp AG setzen:</p>
			      <form name="form1" method="post" action="<?=$location ?>">
			      	nein: <input name="fb_meta_field" value="<?=get_option("0");?>" type="radio" />
			      	ja: <input name="fb_meta_field" value="1" type="radio" checked/>
			      	<input type="submit" value="Speichern" />
			      	<input name="action" value="insert" type="hidden" />
			      </form>
			    </div>
			<?php
			} // Ende Funktion fb_meta_description_option_page()
			
			// Adminmenu Optionen erweitern
			function fb_meta_description_add_menu() {
 					add_option("fb_meta_field","backlinkerlaubnis"); // optionsfield in Tabelle TABLEPRÄFIX_optIons
			    add_options_page('Interhyp AG', 'Baufinanzierung Zinstableau', 9, __FILE__, 'fb_meta_description_option_page'); //optionenseite hinzufügen
			}
			
			// Registrieren der WordPress-Hooks
			add_action('admin_menu', 'fb_meta_description_add_menu');
			//Ende Optionen für Backend

add_action("plugins_loaded", "init_zinstableau");

?>