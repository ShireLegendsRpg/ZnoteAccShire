function calcageEvent2(secs,num1,num2){s=((Math.floor(secs/num1))%num2).toString();if(LeadingZero&&s.length<2)
s="0"+s;return "<b>"+s+"</b>";}
function CountBackEvent2(secs){if(secs<0){document.getElementById("cntdwnevent2").innerHTML=FinishMessage;return;}
DisplayStr=DisplayFormatEvent2.replace(/%%D%%/g,calcageEvent2(secs,86400,100000));DisplayStr=DisplayStr.replace(/%%H%%/g,calcageEvent2(secs,3600,24));DisplayStr=DisplayStr.replace(/%%M%%/g,calcageEvent2(secs,60,60));DisplayStr=DisplayStr.replace(/%%S%%/g,calcageEvent2(secs,1,60));document.getElementById("cntdwnevent2").innerHTML=DisplayStr;if(CountActiveEvent2)
setTimeout("CountBackEvent2("+(secs+CountStepper)+")",SetTimeOutPeriod);}
function putspanEvent2(backcolor,forecolor){document.write("<div class='countdown-event'><span id='cntdwnevent2'></span></font><span id='asdfg'></span></div>");}
if(typeof(BackColor)=="undefined")
BackColor="white";if(typeof(ForeColor)=="undefined")
ForeColor="black";if(typeof(TargetDateEvent2)=="undefined")
TargetDateEvent2="12/31/2020 5:00 AM";if(typeof(DisplayFormatEvent2)=="undefined")
DisplayFormatEvent2="%%H%% Hours, %%M%% Minutes, %%S%% Seconds.";if(typeof(CountActiveEvent2)=="undefined")
CountActiveEvent2=true;if(typeof(FinishMessage)=="undefined")
FinishMessage="Event started.";if(typeof(CountStepper)!="number")
CountStepper=-1;if(typeof(LeadingZero)=="undefined")
LeadingZero=true;CountStepper=Math.ceil(CountStepper);if(CountStepper==0)
CountActiveEvent2=false;var SetTimeOutPeriod=(Math.abs(CountStepper)-1)*1000+990;putspanEvent2(BackColor,ForeColor);var dthen=new Date(TargetDateEvent2);var dnow=new Date(DateNow);if(CountStepper>0)
ddiff=new Date(dnow-dthen);else
ddiff=new Date(dthen-dnow);gsecs=Math.floor(ddiff.valueOf()/1000);CountBackEvent2(gsecs);