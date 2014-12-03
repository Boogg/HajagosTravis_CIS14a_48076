(function () {
			
	var cowRun,
		cowJump,
		cowSquirt,
		cowIdle,
		cowImage,
		sunImage,
		grassImage,
		canvas,
		spriteSize,	
		sun;
	
	//Initial distance variable
	var distance=0;
	
	//canvas dimensions
	var Cwidth= 1000;
	var Cheight= 500;
	
	//the modifier for the size of the sprite
	spriteSize= 0.2;
	
	//initial running speed
	var fps=20;

	//cow object
	var cow= function(x,y){
		this.x = x;
		this.y = y;			
	};
	
	//create a new Cow object with starting x and y coordinates
	var Cow= new cow(200, 375);

	//set the initial state to false
	var jumping = false; 
	
	
	//action when a key is pressed
	onkeydown= function(){
	//Jump cow, jump!
	jumping = true;
	//move the sprite up
	Cow.y -= 10;		
	//constrain to the top of the canvas
		if (Cow.y<=0){
			Cow.y = 0;
		}
	};
	
	//action when the key is released
	onkeyup= function(){
		//ok, stop jumping!
		jumping = false; 	
		//set how fast the fall rate loop runs
		var fall = window.setInterval(function(){
		//action when the cow is in the air and falling
			if(Cow.y < 375 && !jumping){
				Cow.y +=10;
			}else{
			//clear the timer
				window.clearInterval(fall);
			}},1000/fps);
			//keep the cow from falling through the bottom of the canvas
		if(Cow.y > 375){
			Cow.y = 375;
		}
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
		  that.context.clearRect(x-5, y-50, (size*that.width)+5, (size*that.height)+100);
		  
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
	canvas1.width = Cwidth;
	canvas1.height = Cheight;
	var ctx1 = canvas1.getContext("2d");
	//create a gradient
	var my_gradient = ctx1.createLinearGradient(0,0,0,400);
	my_gradient.addColorStop(0,"#0099CC");
	my_gradient.addColorStop(1,"#AEEEEE");
	ctx1.fillStyle = my_gradient;
	ctx1.fillRect(0,0,1000,500);
	
	//Draw the sun
	var canvas2 = document.getElementById("layer2");
	canvas2.width = Cwidth;
	canvas2.height = Cheight;
	var ctx2 = canvas2.getContext("2d");
	//loop for sun animation
	function sunLoop(){
		setTimeout(function(){
			window.requestAnimationFrame(sunLoop);
			sun.update();
			sun.render(60,60, 0.2);
			}, 1000 / 20);
		};
		
	//draw moving grass
	var canvas5 = document.getElementById("layer5");
	canvas5.width= Cwidth;
	canvas5.height= Cheight;
	var ctx5 = canvas5.getContext("2d");
	//set the initial X locations of the grass in an array
	var grassXs = [];
		for (var i = 0; i < 5; i++) { 
			grassXs.push(i*200);
		}
	function grassLoop(){
		setTimeout(function(){
			window.requestAnimationFrame(grassLoop);
			//clear the canvas
			ctx5.clearRect(0,0,1000,500);
			//draw each clump of grass
			for(var i =0; i<=5; i++){
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
	var canvas4 = document.getElementById("layer4");
	canvas4.width = Cwidth;
	canvas4.height = Cheight;
	var ctx4 = canvas4.getContext("2d");
	ctx4.fillStyle="#00CD00";
	ctx4.fillRect(0,400,1000,100);
		
	//Score Canvas
	var canvasScore= document.getElementById("layerScore");
	canvasScore.width= Cwidth;
	canvasScore.height= Cheight;
	var ctxScore=canvasScore.getContext("2d");
	//distance displaying loop
	function scoreLoop () {
		setTimeout(function(){
			window.requestAnimationFrame(scoreLoop);			
			ctxScore.clearRect(0,0,1000,500);
			ctxScore.font="40px Times New Roman";
			ctxScore.fillStyle="#FFFFFF";
			ctxScore.fillText("Distance "+distance+" feet", 600, 75); 
				}, 10000 / fps );
	};
	
	//foreground/character canvas
	var canvasFG = document.getElementById("layerCharacter");
	canvasFG.width = Cwidth;
	canvasFG.height = Cheight;
	
	//audio
	var audio = new Audio("Moo_Moo_Farm.mp3");
	audio.addEventListener('ended', function() {
		this.currentTime = 0;
		this.play();
	}, false);
	audio.play();
	
	// Create sprite sheet
	cowImage = new Image();	
	sunImage = new Image();
	grassImage = new Image();
	// Load sprite sheet
	grassImage.addEventListener("load", grassLoop);
	cowImage.addEventListener("load", gameLoop);
	cowImage.addEventListener("load", scoreLoop);
	sunImage.addEventListener("load", sunLoop);
	sunImage.src = "images/sunSpriteSheet.png";
	cowImage.src = "images/Cowspritesheet.png";
	grassImage.src = "images/grass.png";
	
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