(function() {
			
	var cowRun,
		cowJump,
		cowSquirt,
		cowIdle,
		cowImage,
		sunImage,
		grassImage,
		cloudImage,
		hillImage,
		canvas,	
		sun;
	
	//Initial distance variable
	var distance=0;
	
	//canvas dimensions
	var elems = document.getElementsByClassName('myCanvas');
	for (var i=0; i < elems.length; i++){
		elems[i].width = 1000;
		elems[i].height = 500;
	}
	
	//the modifier for the size of the sprite
	var spriteSize= 0.2;
	
	//initial running speed
	var fps=20;

	//cow object
	var cow= function(x,y){
		this.x = x;
		this.y = y;			
	};
	
	//create a new Cow object with starting x and y coordinates
	var Cow= new cow(200, 375);

	var jumping = false; //is the cow jumping?
	var jumped = false;	 //has the cow jumped?

	//music
	var music = new Audio("sounds/Moo_Moo_Farm.mp3");
	music.volume=1;
	music.addEventListener('ended', function() {
		this.currentTime = 0;
		this.play();
	}, false);
	music.play();	
	
	//milk squirting sound effect
	var milkSquirt= new Audio("sounds/milkSquirt.mp3");
	milkSquirt.volume = 0.5;
	
	//Which key is being pressed?
//	function displayunicode(e){
//		var unicode=e.keyCode? e.keyCode : e.charCode
//		return unicode;
//		};

	
	//action when a key is pressed
	onkeydown= function(){
	//if(displayunicode(onkeydown) = 32){
	//Jump cow, jump!
	//checks to see if the cow is on the bottom, if she is then jump up animation
	if(!jumped){
		var i=0;
		window.setInterval(function(){
			if(i <= 25){
				Cow.y -=5;
				i++;
				jumped= true;
			}else{
			window.clearInterval();
			};
		}, 8);
	}else{ //if the cow is not at the bottom then do a squirt animation
		Cow.y -=10;
		jumping = true;
		//play sound effect
		milkSquirt.addEventListener('ended', function(){
			this.currentTime = 0;
			this.play();
		}, false);
		milkSquirt.play();
	};
		//constrain to the top of the canvas
		if (Cow.y<=0){
			Cow.y = 0;
		};
	};
	
	//action when the key is released
	onkeyup= function(){
		//ok, stop jumping!
		jumping = false; 	
		//set how fast the fall rate loop runs
		var fall = window.setInterval(function(){
			//action when the cow is in the air and falling
			if(Cow.y < 375 && !jumping){
				Cow.y +=20;
				if(Cow.y > 375){
				Cow.y = 375;
				};
			}else{
				//clear the timer
				window.clearInterval(fall);

			}},1000/fps);
		//keep the cow from falling through the bottom of the canvas
		milkSquirt.pause();
		milkSquirt.currentTime = 0;

	};

	//controls which animation is currently suppose to be displayed.
	function gameLoop () {
		setTimeout(function(){
			window.requestAnimationFrame(gameLoop);	

		//if a key is being pressed
		if(jumping){
			cowSquirt.update();
			cowSquirt.render(Cow.x, Cow.y, spriteSize);
		//if the cow is in the air
		}else if(Cow.y < 375){
			cowJump.update();
			cowJump.render(Cow.x,Cow.y, spriteSize);
		//if the cow is on the ground
		}else{
			cowRun.update();
			cowRun.render(Cow.x, Cow.y, spriteSize);
			jumped = false;
		};	
			}, 1000 / fps );
			distance++;
	}
	
	//Drawing animations for sprites		
	function sprite (options) {
	
		var that = {},
			frameIndex = options.startFrame,
			tickCount = 0,
			ticksPerFrame = options.ticksPerFrame || 0,
			numberOfFrames = options.numberOfFrames || 1;
		
		that.context = options.context;
		that.width = options.width;
		that.height = options.height;
		that.image = options.image;
		
		that.update = function () {

            tickCount += 1;

            if (tickCount > ticksPerFrame) {

				tickCount = 0;
				
                // If the current frame index is in range
                if (frameIndex < options.endFrame) {	
                    // Go to the next frame
                    frameIndex += 1;
                } else {
                    frameIndex = options.startFrame;
                }
            }
        };
		
		that.render = function (x, y, size) {
		
		  // Clear the canvas
		  that.context.clearRect(0, 0, 1000, 500);
		  
		  // Draw the animation
		  that.context.drawImage(
		    that.image,
		    frameIndex * that.width / numberOfFrames,
		    0,
		    that.width / numberOfFrames,
		    that.height,
		    x,
		    y,
		    size*that.width / numberOfFrames,
		    size*that.height);
		};
		return that;
	}
	
// Get/create canvas's
	
	//background canvas
	var canvas1 = document.getElementById("layer1");
	var ctx1 = canvas1.getContext("2d");
	//create a gradient
	var my_gradientBG = ctx1.createLinearGradient(0,0,0,400);
	my_gradientBG.addColorStop(0,"#0099CC");
	my_gradientBG.addColorStop(1,"#AEEEEE");
	ctx1.fillStyle = my_gradientBG;
	ctx1.fillRect(0,0,1000,500);
	
	//Draw the sun
	var canvas2 = document.getElementById("layer2");
	var ctx2 = canvas2.getContext("2d");
	//loop for sun animation
	function sunLoop(){
		setTimeout(function(){
			window.requestAnimationFrame(sunLoop);
			sun.update();
			sun.render(60,60, 0.13);
			}, 1000 / 20);
		};
		
	//draw the clouds
	var canvas3 = document.getElementById("layer3");
	var ctx3 = canvas3.getContext("2d");
	//set initial cloud locations
	var cloud = [];
	for(var i=0; i <3; i++){
		 cloud[i] = {
			x : Math.floor(Math.random() * 1000),
			y : Math.floor((Math.random() * 295)+5)
		};
		cloud.push(cloud[i]);
	};
	function cloudLoop(){
		setTimeout(function(){
			window.requestAnimationFrame(cloudLoop);
			//clear the canvas
			ctx3.clearRect(0,0,1000,500);
			//draw each cloud
			for(var i=0; i<3; i++){
				var X = cloud[i].x;
				var Y = cloud[i].y;
				ctx3.drawImage(cloudImage, X, Y, 100, 50);
				//Float those clouds!
				X -= 1;
				if(X < -128){
					X = 1000;
					Y = Math.floor((Math.random() * 295)+5);
				};
				cloud[i].x = X;
				cloud[i].y = Y;
			};
		}, 1000/7);
	};
	
	//draw the Background hills
	var canvas4 = document.getElementById("layer4");
	var ctx4 = canvas4.getContext("2d");
	//place images into an array
	var hills = [];
	for(var i=0; i<4; i++){
		hills[i] = {sx: (i*1933/4), swidth: (i+(1933/4)), sheight: 373};
	};
	//place starting x points and randomly assign images into an array
	var hillCanvas= [];
	for(var i=0; i<5; i++){
		var y = Math.floor(Math.random() * 3);
		hillCanvas[i] = [i*250, hills[y]];
	};
	//draw those hills
	function hillLoop(){
		setTimeout(function(){
			window.requestAnimationFrame(hillLoop);
			//clear the canvas
			ctx4.clearRect(0,0,1000,5000);
			//draw random hills 
				for(var i =0;i < hillCanvas.length; i++){
				var X = hillCanvas[i][0];
				var hillImg = hillCanvas[i][1];
				var hillsx= hillCanvas[i][1].sx;
				var hillswidth= hillCanvas[i][1].swidth;
				var hillsheight= hillCanvas[i][1].sheight;
				ctx4.drawImage(hillImage, hillsx, 0, hillswidth, hillsheight, X, 275, 251, 195);
				//Move those hills
				X -=1;
				if( X < -250){
					X = 1000;
					var Y= Math.floor(Math.random() * 3);
				var hillImg = hills[Y]
				};
				hillCanvas[i][0] = X;
				hillCanvas[i][1] = hillImg;
			};
		}, 1000/(fps*0.75));
	};
	
	
	//draw moving grass
	var canvas5 = document.getElementById("layer5");
	var ctx5 = canvas5.getContext("2d");
	//set the initial X locations of the grass in an array
	var grassXs = [];
		for (var i = 0; i < 5; i++){ 
			grassXs.push(i*200);
		}
	function grassLoop(){
		setTimeout(function(){
			window.requestAnimationFrame(grassLoop);
			//clear the canvas
			ctx5.clearRect(0,0,1000,500);
			//draw each clump of grass
			for(var i =0; i< 5; i++){
				var X = grassXs[i];
				ctx5.drawImage(grassImage, X, 350, 100, 50);
				//Move your GRASS!
				X -= 10;
				if(X< -100){
					X = 1000;
				};
				grassXs[i]= X;
			};
		}, 1000 /fps);
	};
		
	//drawing the ground
	var canvas6 = document.getElementById("layer6");
	var ctx6 = canvas6.getContext("2d");
	var my_gradientGRD = ctx6.createLinearGradient(0,400,0,500);
	my_gradientGRD.addColorStop(0,"#00CD00");
	my_gradientGRD.addColorStop(0.3,"#B67721");
	my_gradientGRD.addColorStop(1,"#00CD00");
	ctx6.fillStyle = my_gradientGRD;
	ctx6.fillRect(0,400,1000,100); 
		
	//Score Canvas
	var canvasScore= document.getElementById("layerScore");
	var ctxScore=canvasScore.getContext("2d");
	//distance displaying loop
	function scoreLoop () {
		setTimeout(function(){
			window.requestAnimationFrame(scoreLoop);			
			ctxScore.clearRect(0,0,1000,500);
			ctxScore.font="40px Times New Roman";
			ctxScore.fillStyle="#000000";
			ctxScore.fillText("Distance "+distance+" feet", 600, 75); 
		}, 10000 / fps );
	};
	
	//foreground/character canvas
	var canvasFG = document.getElementById("layerCharacter");
		
	// Create sprite sheet
	cowImage = new Image();	
	sunImage = new Image();
	grassImage = new Image();
	cloudImage = new Image();
	hillImage = new Image();
	
	// Load sprite sheet
	grassImage.addEventListener("load", grassLoop);
	cowImage.addEventListener("load", gameLoop);
	cowImage.addEventListener("load", scoreLoop);
	sunImage.addEventListener("load", sunLoop);
	cloudImage.addEventListener("load", cloudLoop);
	hillImage.addEventListener("load", hillLoop);
	
	//function(){ctx4.drawImage(hillImage, 0, 250, 1000,195)});
	
	//load images
	sunImage.src = "images/sunSpriteSheet.png";
	cowImage.src = "images/Cowspritesheet.png";
	grassImage.src = "images/grass.png";
	cloudImage.src = "images/cloud.png";
	hillImage.src = "images/hills.png";
	
	// Create sprites

	cowRun = sprite({
		context: canvasFG.getContext("2d"),
		width: 2150,
		height: 450,
		image: cowImage,
		numberOfFrames: 5,
		ticksPerFrame: 2,
		startFrame: 1,
		endFrame: 2
	});
	cowSquirt = sprite({
		context: canvasFG.getContext("2d"),
		width: 2150,
		height: 450,
		image: cowImage,
		numberOfFrames: 5,
		ticksPerFrame: 2,
		startFrame: 3,
		endFrame: 4
	});
	cowJump = sprite({
		context: canvasFG.getContext("2d"),
		width: 2150,
		height: 450,
		image: cowImage,
		numberOfFrames: 5,
		ticksPerFrame: 2,
		startFrame: 1,
		endFrame: 1
	});
	cowIdle = sprite({
		context: canvasFG.getContext("2d"),
		width: 2150,
		height: 450,
		image: cowImage,
		numberOfFrames: 5,
		ticksPerFrame: 2,
		startFrame: 0,
		endFrame: 0
	});
	sun = sprite({
		context:ctx2,
		width: 1290,
		height: 645,
		image:sunImage,
		numberOfFrames: 2,
		ticksPerFrame: 10,
		startFrame: 0,
		endFrame: 1
	});

} ());