
    <body onload="window.print()">
      @foreach($products as $product)
    <div id="elem" style="text-align:center;">
          <span style="font-size:12px;">Mercury Pharmacy</span>
          <br>
          <!--<img src="{{url('img/barcode1.png')}}" width="114px" height="76px">-->
          <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($product->product->barcode, 'C39','1','40')}}" alt="barcode" /><br>
          {{$product->product->barcode}} <span style="font-size:14px;">({{$product->default_sale_price}} SAR)</span><br>
          <span style="font-size:14px;">
            @if($lang == 'en')
            {{Str::limit($product->name_en,30)}} 
            @else
            {{Str::limit($product->name_ar,30)}} 
            @endif
          </span> 
          

        </div><br>
@endforeach
<!--
<div style="text-align: center;">
		<img src="data:image/png;base64,{{DNS1D::getBarcodePNG('11', 'C39')}}" alt="barcode" /><br><br>
		<img src="data:image/png;base64,{{DNS1D::getBarcodePNG('123456789', 'C39+',1,33,array(0,255,0), true)}}" alt="barcode" /><br><br>
		<img src="data:image/png;base64,{{DNS1D::getBarcodePNG('4', 'C39+',3,33,array(255,0,0))}}" alt="barcode" /><br><br>
		<img src="data:image/png;base64,{{DNS1D::getBarcodePNG('12', 'C39+')}}" alt="barcode" /><br><br>
		<img src="data:image/png;base64,{{DNS1D::getBarcodePNG('23', 'POSTNET')}}" alt="barcode" /><br/><br/>
	</div>
    -->    
</body>


  

    
