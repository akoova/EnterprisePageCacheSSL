![alt text](https://akoova.com/wp-content/uploads/2019/05/logo-retina-reduced.png "Akoova")  
[akoova.com](https://akoova.com) Email: [info@akoova.com](info@akoova.com) Twitter: [@akoova](https://twitter.com/akoova)

Magento Enterprise Full Page Cache under SSL
============================================
Normally the Full Page Caching of Magento Enterprise doesn't work under SSL / HTTPS.
This extension overcome this limitation.

Typically e-commerce sites use HTTPS only for checkout, account page, sign-in, registration etc...
However, since Google's announcement "HTTPS as a ranking signal" on the 6th Aug 2014, we expect merchants
to start adopting HTTPS for the whole site.

This would be a major problem, especially for Magento Enterprise sites.
More details can be found on the Elastera's blog "Why Google’s advice on HTTPS will screw your Magento site"

https://akoova.com/why-google-advice-on-https-will-screw-your-magento-site/

We've encountered Devs and Ops of a merchant blaming each other at length fo the performance issues, due to the above.
We hope this will help merchants avoid a possibly a costly and frustrating issue.

Configuration
======================
After installation of the module, you will need to modify app/etc/enterprise.xml and change the `<request_processor>` to
```
<request_processors>
  <ee>Elastera_EnterprisePageCacheSSL_Model_Processor</ee>
</request_processors>
```

Compatible
======================
Tested with Magento EE 1.12, 1.13 and 1.14.
