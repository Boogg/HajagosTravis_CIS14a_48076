(function () {
			
	var cowRun,
		cowJump,
		cowSquirt,
		cowIdle,
		cowImage,
		canvas,
		spriteSize;	
		
		
	//the modifier for the size of the sprite
	spriteSize= 0.2;
	
	//initial running speed
	var fps=30;

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
	}
			
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
	//canvas = document.getElementsByClass("myCanvas");
	
	//background canvas
	canvasBG = document.getElementById("layer1");
	canvasBG.style.backgroundColor = "#00B2EE";
	canvasBG.width = 1000
	canvasBG.height = 500

	//drawing to the background canvas
	var ctx= canvasBG.getContext("2d");
	//drawing the ground
		ctx.fillStyle="green";
		ctx.fillRect(0,400,1000,100);

	//drawing to the foreground canvas
	canvasFG = document.getElementById("layerTop");
	canvasFG.width = 1000
	canvasFG.height = 500
	
	
	
	// Create sprite sheet
	cowImage = new Image();	
	
	// Load sprite sheet
	cowImage.addEventListener("load", gameLoop);
	cowImage.src = "images/Cowspritesheet.png";
	
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




} ());