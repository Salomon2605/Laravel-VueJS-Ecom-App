import { ref } from "vue";
import { loadStripe  } from "@stripe/stripe-js";
import axios from "axios";

export default function useStripe() {
    // This is your test publishable API key.
    const stripePromise = loadStripe(import.meta.env.VITE_STRIPE_TEST_PUBLIC_KEY);

    let elements;
    let emailAddress = '';

    const initialize = async() => {
        const stripe = await stripePromise;

        const clientSecret = await axios.post('/paymentIntent')
                                  .then(r => r.data.clientSecret)
                                  .catch(err => console.log(err));
        
        elements = stripe.elements({ clientSecret });
    
        const linkAuthenticationElement = elements.create("linkAuthentication");
        linkAuthenticationElement.mount("#link-authentication-element");
        
        const paymentElementOptions = {
           layout: "tabs",
        };
    
        const paymentElement = elements.create("payment", paymentElementOptions);
        paymentElement.mount("#payment-element");
    }

    const handleSubmit = async() => {
        setLoading(true);

        const stripe = await stripePromise;

        const { error } = await stripe.confirmPayment({
          elements,
          confirmParams: {
            // Make sure to change this to your payment completion page
            return_url: "http://127.0.0.1:8000/checkout",
            receipt_email: emailAddress,
          },
        });
      
        // This point will only be reached if there is an immediate error when
        // confirming the payment. Otherwise, your customer will be redirected to
        // your `return_url`. For some payment methods like iDEAL, your customer will
        // be redirected to an intermediate site first to authorize the payment, then
        // redirected to the `return_url`.
        if (error.type === "card_error" || error.type === "validation_error") {
          showMessage(error.message);
        } else {
          showMessage("An unexpected error occurred.");
        }
      
        setLoading(false);
    }

    const checkStatus = async() => {
        const clientSecret = new URLSearchParams(window.location.search).get(
            "payment_intent_client_secret"
          );
        
          if (!clientSecret) {
            return;
          }

          const stripe = await stripePromise;
        
          const { paymentIntent } = await stripe.retrievePaymentIntent(clientSecret);
        
          switch (paymentIntent.status) {
            case "succeeded":
              showMessage("Payment succeeded!");
              break;
            case "processing":
              showMessage("Your payment is processing.");
              break;
            case "requires_payment_method":
              showMessage("Your payment was not successful, please try again.");
              break;
            default:
              showMessage("Something went wrong.");
              break;
          }
    }

    // ------- UI helpers -------

    const showMessage = (messageText) => {
        const messageContainer = document.querySelector("#payment-message");
    
        messageContainer.classList.remove("hidden");
        messageContainer.textContent = messageText;
    
        setTimeout(function () {
            messageContainer.classList.add("hidden");
            messageContainer.textContent = "";
        }, 4000);
    }
  
    // Show a spinner on payment submission
    const setLoading = (isLoading) => {
        if (isLoading) {
            // Disable the button and show a spinner
            document.querySelector("#submit").disabled = true;
            document.querySelector("#spinner").classList.remove("hidden");
            document.querySelector("#button-text").classList.add("hidden");
        } else {
            document.querySelector("#submit").disabled = false;
            document.querySelector("#spinner").classList.add("hidden");
            document.querySelector("#button-text").classList.remove("hidden");
        }
    }

    return {
        initialize,
        checkStatus,
        handleSubmit
    }
}