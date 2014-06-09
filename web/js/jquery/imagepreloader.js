function preloadImages(img){
	
	var picArr = [];
	
		for (i = 0; i<img.length; i++){
			
				picArr[i]= new Image(100,100); 
				picArr[i].src=img[i]; 

			
			}
	
	}