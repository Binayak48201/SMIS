
function plotData() {
  var canvas;
  var ctx;
  var lastend = 0;
  var myTotal = this.myTotal;
  var doc;
  canvas = document.getElementById(this.plotId);
  var x = (canvas.width)/2;
  var y = (canvas.height)/2;
  var r = 100;
  
  ctx = canvas.getContext("2d");
  ctx.clearRect(0, 0, canvas.width, canvas.height);

  for (var i = 0; i < this.myData.length; i++) {
    ctx.fillStyle = this.myColor[i];
    ctx.beginPath();
    ctx.moveTo(x,y);
    ctx.arc(x,y,r,lastend,lastend+(Math.PI*2*(this.myData[i]/myTotal)),false);
    ctx.lineTo(x,y);
    ctx.fill();
    
    // Now the pointers
    ctx.beginPath();
    var start = [];
    var end = [];
    var last = 0;
    var flip = 0;
    var textOffset = 0;
    var precentage = (this.myData[i]/myTotal)*100;
    start = getPoint(x,y,r-20,(lastend+(Math.PI*2*(this.myData[i]/myTotal))/2));
    end = getPoint(x,y,r+20,(lastend+(Math.PI*2*(this.myData[i]/myTotal))/2));
    if(start[0] <= x)
    {
      flip = -1;
      textOffset = -110;
    }
    else
    {
      flip = 1;
      textOffset = 50;
    }
    ctx.moveTo(start[0],start[1]);
    ctx.lineTo(end[0],end[1]);
    ctx.lineTo(end[0]+110*flip,end[1]);
    ctx.strokeStyle = "#35485d";
    ctx.lineWidth   = 1;
    // The labels
    ctx.font="11px Arial";
    if(precentage>=1){
      ctx.stroke();
      ctx.fillText(this.myLabel[i]+" "+precentage.toFixed(2)+"%",end[0]+textOffset,end[1]-2); 
    }
    // Increment Loop
    lastend += Math.PI*2*(this.myData[i]/myTotal);
    
  }
}
function getTotal(){
  var myTotal = 0;
  for (var j = 0; j < this.myData.length; j++) {
    myTotal += (typeof this.myData[j] == 'number') ? this.myData[j] : 0;
  }
  return myTotal;
}
// Find that magical point
function getPoint(c1,c2,radius,angle) {
  return [c1+Math.cos(angle)*radius,c2+Math.sin(angle)*radius];
}


function initPie()
{
  this.myColor = ["#39ca74","#e54d42","#f0c330","#3999d8"];
  this.myData = [50,30,3,17];
  this.myLabel = ["NQ","Fail","Abs","Pass"];
  this.plotId='canvas';
  this.getTotal= getTotal;
  this.setChart = plotData;
}