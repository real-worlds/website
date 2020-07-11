


p1=0.0048139;  p2=3.1797;   p3=1.4391;  p4=-1.2195;  p5=3.8978;  p6=9.6027; 
a=0.31108;  b=0.48951; 
c=0.28822;
z1=2.3;z2=7.9; z3=6.1; v0=2.15e5;
var t0 = Date.UTC(2016,9,1);

function timedEval() {
	var t1 = Date.now();
	var dt=(t1-t0)/(8.64e7);
	v1=Math.exp(p1*dt+p2);
	v2=Math.exp(a*Math.pow(dt,b));
	v3=Math.exp(c*Math.sqrt(dt));
	v=Math.round( v0*(v1*z1+z2*v2+z3*v3)/(z1+z2+z3) );

	postMessage(v);
	setTimeout("timedEval()",getRandomInt(75, 125));
}

function getRandomInt(min, max) { return Math.floor(Math.random() * (max - min + 1)) + min; }

timedEval();

 