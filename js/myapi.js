// function to get url parameters
var getUrlParameter = function getUrlParameter(sParam) {
  var sPageURL = decodeURIComponent(window.location.search.substring(1)),
      sURLVariables = sPageURL.split('&'),
      sParameterName,
      i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};

var action = getUrlParameter('action');
var numbers = getUrlParameter('numbers');

if(action !== undefined && numbers !== undefined)
  restApi(action, numbers);

// Make API call
function restApi(action, numbers)
{
  // do some basic auth.
  var client = new $.RestClient('http://localhost/myapi/rest/', {
    username: 'restuser@example.com',
    password: '' // add your password here.
  });

  client.add('sumandcheck', {
    stripTrailingSlash: true,
  });

  client.add('check', {
    stripTrailingSlash: true,
  });

  switch(action) 
  {
    case 'sumandcheck':
      client.sumandcheck.read(numbers).done(function (data){
        $('#result, .sum').show();
        $('.sum span').html(data.result);
        var isPrime = (data.isPrime) ? 'Kyllä' : 'Ei';
        $('.isPrime span').html(isPrime);
      });
    break;
    case 'check':
      client.check.read(numbers).done(function (data){
        $('#result').show();
        $('.sum').hide();
        var isPrime = (data.isPrime) ? 'Kyllä' : 'Ei';
        $('.isPrime span').html(isPrime);
      });
    break;
    default:
      alert('Hups! Jokin meni vikaan');
  }
}

$(document).ready(function() {
  $('#submit-button').on('click', function(e) {
    e.preventDefault();
    $('#result').hide();
    $('.sum span').html('');
    $('.isPrime span').html('');
    var data = $('#apiform').serializeArray();
    var numbers = data[0].value;
    var action = data[1].value;
    restApi(action, numbers);
  });
});