
    <body onload="window.print()">
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
        
</body>


  

    
