function calcageEvent(secs,num1,num2){s=((Math.floor(secs/num1))%num2).toString();if(LeadingZero&&s.length<2)
s="0"+s;return "<b>"+s+"</b>";}
function CountBackEvent(secs){if(secs<0){document.getElementById("cntdwnevent").innerHTML=FinishMessage;return;}
DisplayStr=DisplayFormatEvent.replace(/%%D%%/g,calcageEvent(secs,86400,100000));DisplayStr=DisplayStr.replace(/%%H%%/g,calcageEvent(secs,3600,24));DisplayStr=DisplayStr.replace(/%%M%%/g,calcageEvent(secs,60,60));DisplayStr=DisplayStr.replace(/%%S%%/g,calcageEvent(secs,1,60));document.getElementById("cntdwnevent").innerHTML=DisplayStr;if(CountActiveEvent)
setTimeout("CountBackEvent("+(secs+CountStepper)+")",SetTimeOutPeriod);}
function putspanEvent(backcolor,forecolor){document.write("<div class='countdown-event'><span id='cntdwnevent'></span></font><span id='asdfg'></span></div>");}
if(typeof(BackColor)=="undefined")
BackColor="white";if(typeof(ForeColor)=="undefined")
ForeColor="black";if(typeof(TargetDateEvent)=="undefined")
TargetDateEvent="12/31/2020 5:00 AM";if(typeof(DisplayFormatEvent)=="undefined")
DisplayFormatEvent="%%H%% Hours, %%M%% Minutes, %%S%% Seconds.";if(typeof(CountActiveEvent)=="undefined")
CountActiveEvent=true;if(typeof(FinishMessage)=="undefined")
FinishMessage="Event started.";if(typeof(CountStepper)!="number")
CountStepper=-1;if(typeof(LeadingZero)=="undefined")
LeadingZero=true;CountStepper=Math.ceil(CountStepper);if(CountStepper==0)
CountActiveEvent=false;var SetTimeOutPeriod=(Math.abs(CountStepper)-1)*1000+990;putspanEvent(BackColor,ForeColor);var dthen=new Date(TargetDateEvent);var dnow=new Date(DateNow);if(CountStepper>0)
ddiff=new Date(dnow-dthen);else
ddiff=new Date(dthen-dnow);gsecs=Math.floor(ddiff.valueOf()/1000);CountBackEvent(gsecs);