var MyAlert = function() {
  var handle = function(e, mail) {
    alert(mail.subject);
  }
  $.subscribe("newMailReceived", handle); 
}

var Message = function() {
  var handle = function(e, mail) {
    $('#result').html(mail.subject);
  }
 
  $.subscribe("newMailReceived", handle); 
}

$(function() {
    var o = $({});

    $.subscribe = function() {
        o.on.apply(o, arguments);
    };
  
    $.unsubscribe = function() {
        o.off.apply(o, arguments);
    };
  
    $.publish = function() {
        o.trigger.apply(o, arguments);
    };
  
    // var message = new Message();
    // var myAlert = new MyAlert();
  
    // $.publish("newMailReceived", {subject: 'Hello', message:'Hi'})

});






