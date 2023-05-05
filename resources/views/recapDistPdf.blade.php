<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<style>
			body{
				background: white;
				font-family: sans-serif;
			}
			table,th,td{
				border:2px solid black;
				border-collapse: collapse;
				font-size: 14px !important;
			}
			th{
				text-align: left;
			}
			p{
				line-height: 1.2;
				font-size: 15px !important;
				margin-top: 0px;
			}
			
			#logo2{
				width:50px;
				
				padding-bottom:5px;
			}
			#logo3{
				width:90px;
				padding-bottom:5px;
			}
		</style>
		
	</head>
	<body >
		<div>
				<div style="text-align: center;">
						<img id="logo3" src="data:image/jpg;base64,{{ $logo2 }}"/>
					<p style="margin-top: -15px;"><b>REPOBLIKAN´I MADAGASIKARA<br>
						Fitiavana - Tanindrazana - Fandrosoana</b><br>
						<span style="font-size: 17px;">**********</span> 
					</p>
				</div>
	
				<div style="margin-top: -50px;width: 445px;text-align: center;">
					<img id="logo2" src="data:image/jpg;base64,{{ $logo }}"/>
					<p style="margin-top: -10px;"><span style="margin-left: 15px;">MINISTERE DE L'EDUCATION NATIONALE ET DE </span><br>
						L'ENSEIGNEMENT TECHNIQUE ET PROFESSIONNEL<br>
						<span style="font-size: 17px;">********** </span><br>
						DIRECTION REGIONALE DE L'EDUCATION NATIONALE ET DE <br>
						L'ENSEIGNEMENT TECHNIQUE ET PROFESSIONNEL<br>
						ATSIMO-ATSINANANA<br>
					<span style="font-size: 17px;">********** </span><br>
						CISCONSCRIPTION SCOLAIRE {{ $cisco }}<br>
						<span style="font-size: 17px;">********** </span></p>
				</div>
			</div>
			<div style="margin-top: -10px;text-align: center;">
				<p >
					<b>BORDEREAU DESCRIPTIF DE<br> DISTRIBUTION
						DES KITS SCOLAIRES</b> <br>
						<span style="font-size: 17px">********** </span>
				</p>
			</div>
			
			<div style="margin-top: -10px;">
					<p>
						CISCO <b>:</b> {{ $cisco }} <br>
						ZAP <b>:</b>  {{ $zap }}<br>
						EPP <b>:</b>  {{ $ecole }}<br>
						CODE ECOLE <b>:</b> {{ $code }}
						</b>  
					</p>
			</div>
			<div>
					<table style="width: 100%;">
						<tr>
							<th>N°</th>
							<th>ARTICLE</th>
							<th>SOURCE</th>
							<th>BENEFICIAIRE</th>
							<th>DISTRIBUE</th>
						</tr>
						@foreach ($res as $key => $item)
						<tr>
							<td>{{ ++$key }}</td>
							<td>{{ $item->design }}</td>
							<td>{{ $item->source }}</td>
							<td>{{ $item->benef }}</td>
							<td>{{ number_format($item->qte,0,'.',' ') }}</td>

						</tr>
						@endforeach
						<tr>
							<th colspan="4" style="text-align: right;">TOTAL</th>
							<td>{{ number_format($total,0,'.',' ') }}</td>
							
						</tr>
					</table>
					<p style="margin-top: 10px;">
					ARRETEE LE PRESENT BORDEREAU AU NOMBRE DE ({{ $counter }}) ARTICLE{{ $counter > 0 ? 'S' : '' }} A DISTRIBUER ET AU TOTAL DE ({{number_format($total,0,'.',' ')}})
					DE L´ANNEE SCOLAIRE {{ $anne_scolaire }}. 
					</p> 
			
				
			</div>
			<div style="text-align: center;">
				
					<p>
						Fait à ......................................, le .....................................
					</p>
				
			</div>
		</div>
	</body>
</html>




