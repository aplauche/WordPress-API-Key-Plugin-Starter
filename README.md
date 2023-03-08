# Basic Protected API Key Implementation

This starter plugin provides a basic implementation of protecting an API key in the WordPress database by encrypting it.

It provides a settings page under the tools menu where site editors can update the API key.

On this page is a button to test and make sure the setup is working properly. You can also reference the script triggered by this button to see how to format requests to the custom REST endpoint that will handle our API requests.

You should update the textdomain, prefixes, and ideally namespace the encryption class if using on a production site.

The current API request from the REST endpoint handler is for demo purposes only. The request will fail even if a valid google API key is provided. Replace the curl request with your own protected API endpoint and reformat accordingly.

An example request to use the API would look like this:

```
<script>
  async function useExternalApi(){
    const res = await fetch("<?php echo home_url( ); ?>/wp-json/fsd/v1/fetch-external-api", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        // Only needed if your permission callback is something other than __return_true
        // If using in javascript file you may need to use localize_script to get access to the nonce rather than dropping into php
        "X-WP-Nonce": "<?php echo wp_create_nonce( 'wp_rest' ) ?>"      
      },
      body: JSON.stringify({
        exampleValue: "example"
      })
    });
    const data = await res.json()
    console.log(data)
    // Do something with the data ...
  }
  </script>
```