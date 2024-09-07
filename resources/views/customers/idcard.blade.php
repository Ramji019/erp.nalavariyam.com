<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<style>
		@font-face {
			font-family: 'arial-unicode-ms';`
			font-style: normal;
			font-weight: normal;
			src: url("{{ url('arial-unicode-ms.ttf') }}") format('truetype');
			}

			.id-card-holder {
				width: 238px;
				height: 148px;
				padding: 4px;
				border-radius: 5px;
				background-image: url("{{ url('upload/idcard/front.jpg') }}");
				background-repeat: no-repeat;
				background-size: contain;
				visibility: visible;
				-webkit-print-color-adjust: exact;
			}
			.id-card-back {
				width: 238px;
				height: 148px;
				padding: 4px;
				border-radius: 5px;
				background-image: url("{{ url('upload/idcard/back.jpg') }}");
				background-repeat: no-repeat;
				background-size: contain;
				visibility: visible;
				-webkit-print-color-adjust: exact;
			}
			.id-card {
				padding: 10px;
				border-radius: 10px;
				text-align: center;
			}
			.id-card img {
				margin: 0 auto;
			}
			.myaddress{
				font-family: monospace;
				border: 0px solid #ddd;
				color: black;
				max-width: 24ch;
				word-wrap:break-word;
			}
			@media print {
				#printPageButton {
					display: none;
				}
			}
			.printbutton {
			  background-color: #4CAF50; /* Green */
			  border: none;
			  color: white;
			  padding: 15px 32px;
			  text-align: center;
			  text-decoration: none;
			  display: inline-block;
			  font-size: 12px;
			}
		</style>
	</head>
	<body style="background-color:white" >
		<div class="id-card-holder" id="topdiv">
			<div class="id-card" style="font-weight:bold;margin-top: 29px;margin-left:180px;font-size:6px">{{ $specialmembers->registeration_no }}</div>	
			<div>	
				<table style="font-size:8px;margin-top: -10px;" width="100%">
					<tr>
						<td valign="top" align="center">
							<img valign="top" width="40" height="50" border="1" src="{{ url('upload/member_photo/') }}/{{ $specialmembers->member_photo }}" />
							<b><p style="font-size:5px;">SM {{ $specialmembers->id }}</p></b>
						</td>
						<td  valign="top">
							<table cellspacing="0" width="100%" align="left" >
								<tr><td style="font-size:5px;font-family: arial-unicode-ms">முழு பெயர்</td><td>&nbsp;:&nbsp;</td><td style="font-size:5px;font-weight: bold;font-family: arial-unicode-ms">{{ $specialmembers->full_name }}</td><td width="20%">&nbsp;</td></tr>

								<tr><td style="font-size:5px;font-family: arial-unicode-ms">தொழில்</td><td>&nbsp;:&nbsp;</td><td colspan="2" style="font-size:5px;font-weight: bold;font-family: arial-unicode-ms">{{ $specialmembers->work_there_name }}</td></tr>

								<tr><td style="font-size:5px;font-family: arial-unicode-ms">பிறந்த தேதி</td><td>&nbsp;:&nbsp;</td><td style="font-weight: bold;font-size:5px;">{{ date("d-M-Y",strtotime($specialmembers->dob)) }}</td><td>&nbsp;</td></tr>

								<tr><td style="font-size:5px;font-family: arial-unicode-ms">முகவரி</td><td>&nbsp;:&nbsp;</td><td colspan="2" style="font-weight: bold;font-size:5px;font-family: arial-unicode-ms">{{ $specialmembers->street_name }}<br> {{ $specialmembers->post_name }}<br>{{ $cust_dist_name }} {{ $specialmembers->pincode }} </td></tr>

								<tr><td style="font-size:5px;font-family: arial-unicode-ms">தொலைபேசி</td><td>&nbsp;:&nbsp;</td><td style="font-weight: bold;font-size:5px;">{{ $specialmembers->phone }}</td><td width="30%" align="right"></td></tr>
							</table>
						</td>
					</tr>
					</table>
					
					<center>
					<table>
					<tr>
					<b><td style="font-size:5px;font-family: arial-unicode-ms;padding-top: 5px;font-weight: bolder;">
					<center>{{ $district_name }}, {{ $district_user }} </br>{{ $district_address }}.</br>www.nalavariyam.com, Ph: {{ $district_phone }}.</center></b>
					</td>
					</tr>
				</table>
				</center>
				
			</div>
		</div>
			<div class="id-card-back"></div>

		 <div style="width:238px;text-align:center" id="printPageButton" >
			<br>
			<input onclick="window.print()" class="printbutton"  type="button" value="PRINT"  />
		</div>
	</body>
	<script>
		$( document ).ready(function() {
			//html2canvas($("#topdiv")[0],{width: 246,height: 156,scale: 1}).then((canvas) => {
			/*html2canvas($("#topdiv")[0]).then((canvas) => {
				var name = "{{ $idcard }}";
				const a = document.createElement("a");
				document.body.appendChild(a);
				a.style = "display: none";
				a.href = canvas.toDataURL();
				a.download = name;
				a.click();
				document.body.removeChild(a);
			});*/
		});
	</script>
	<html>

