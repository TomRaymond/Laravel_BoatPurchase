<!DOCTYPE html>
<html lang="en">
<head>
  <title>Stripe Payment</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    @php
        $stripe_key = env('STRIPE_KEY');
    @endphp
    
    <div class="container" style="margin-top:10%;margin-bottom:10%">
        <div class="row justify-content-center">
            <div class="col-md-12">
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12 mt-4">
                <div class="">
                    <h2>You are making a payment for £500,000</h2>
                </div>
                <div class="card">
                    <form action="{{route('checkout.purchase-complete')}}" method="post" id="payment-form">
                        @csrf            
                        <div class="col-md-12">
                            <label for="InputEmail" class="form-label mt-4">Where would you like us to send confirmation of your purchase?</label>
                            <input type="text" class="form-control" name="email" id="input-email" aria-describedby="emailHelp" placeholder="Enter email">
                            <div id="email-errors" role="alert"></div>
                        </div>        
                        <div class="form-group mt-4">
                            <div class="card-header">
                                <label for="card-element">
                                    Enter your credit card information
                                </label>
                            </div>
                            <div class="card-body">
                                <div id="card-element">
                                <!-- A Stripe Element will be inserted here. -->
                                </div>
                                <!-- Used to display form errors. -->
                                <div id="card-errors" role="alert"></div>
                                <input type="hidden" name="plan" value="" />
                            </div>
                        </div>
                        <div class="card-footer">
                          <button
                          id="card-button"
                          class="btn btn-dark"
                          type="submit"
                          data-secret="{{ $intent }}"
                        > Pay </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        // Custom styling can be passed to options when creating an Element.
        // (Note that this demo uses a wider set of styles than the guide below.)

        var style = {
            base: {
                color: '#32325d',
                lineHeight: '18px',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };
    
        const stripe = Stripe('{{ $stripe_key }}', { locale: 'en' }); // Create a Stripe client.
        const elements = stripe.elements(); // Create an instance of Elements.
        const cardElement = elements.create('card', { style: style }); // Create an instance of the card Element.
        const cardButton = document.getElementById('card-button');
        const clientSecret = cardButton.dataset.secret;
    
        cardElement.mount('#card-element'); // Add an instance of the card Element into the `card-element` <div>.
    
        // Handle real-time validation errors from the card Element.
        cardElement.addEventListener('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        const validateEmail = (email) => {
            return email.match(
                /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
            );
        };

        var isEmailInvalid = true; // does the form have a valid email address entered
        var email = document.getElementById('input-email');
        const $result = $('#email-errors');
        const $email_field = $('#input-email');
        email.addEventListener('input', function(event) {            
            const email = $email_field.val();
            $result.text('');

            if (validateEmail(email)) {
                $result.text('');
                $email_field.css('color', 'black');
                isEmailInvalid = false;
            } else if (email === '') {            
                $result.text('');
                $email_field.css('color', 'black');
                isEmailInvalid = true;
            } else {
                $result.text('The address given does not appear to be a valid email address');
                $email_field.css('color', 'red');
                isEmailInvalid = true;
            }
        });    
    
        // Handle form submission.
        var form = document.getElementById('payment-form');
        var isFormSubmitted = false;
    
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            if(isFormSubmitted) return; // user has already clicked submit 
            if(isEmailInvalid){
                $result.text('The address given does not appear to be a valid email address');
                $email_field.css('color', 'red');
                isEmailInvalid = true;
                return;
            }
        $('#card-button').text('Processing...'); // show user that the click did something

        stripe.handleCardPayment(clientSecret, cardElement, {
                payment_method_data: {
                    //billing_details: { name: cardHolderName.value }
                }
            })
            .then(function(result) {
                if (result.error) {
                    // Inform the user if there was an error.
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                    $('#card-button').text('Pay');
                } else {
                    isFormSubmitted = true;
                    $('#card-button').text('Processing...');
                    form.submit();
                }
            });
        });
    </script>
</body>
</html>