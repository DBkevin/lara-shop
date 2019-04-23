<?php

return [
    'alipay' => [
        'app_id' => '2016092700608186',
        'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAwjgCnL8/8O1V24JmKjKRzzY8nlQrXnFTIzcIbxPJ+ezsgNLomGLDbrOtHq+rBuTS8FN4piG89/wEs7FMJcSA3M2LAGAkXTz+/TUd1XqK1VOzsmthLpiIrpHYSki8pyjh3hcsPJqyofOkZOIk2aGFUkS0k/p0WBTnGHJfndCwK0FeR4wl0xyfUjKtGx5XOwTsAghPeFlEP7mkII0lIpJB8GWxUpZZQOXP3+si4TqePoEnJojjE0hE5nM1f4QHmfJbJOHI52awk3lVN4EgDS1QvwfTyoDhTNUKOS2bbN5uurp8xubK27D5oME4EDPzG7CRBRKbSYHZla8k/257+eezIwIDAQAB',
        'private_key' => 'MIIEowIBAAKCAQEAs3VdekLIWC/04j+E28rf6XQZUFWU9eIvp6URIu0XNTFW/x8f5KaMucY9QW5QL0pPr1gEI9rZe+bEH9jcXnmcq3SzX7iLXC6MfiprXkfIaifU9fn83OT2e41WhdtDn1FgRbED/rROKPy7gMzMx9whUAUAqJcYvD77c9LISoRQQIcjuCHpjW3JVEWcdxriITL/P1f9PcbwFgyaBuUid/QIG+NWAB87LvBgGJpGIe3zQblGt/Pd5w+sl1WwxT3daDAjBHQCNG9sEV8IdyvsSN/Ffp5XJdGxUdzUE17VlWdI2x2QlloRR2/DWN5jh5t4UC/VeqsJsskCc0Z5aLRYth0I3QIDAQABAoIBAH1wwoCdgdEy5GfpooLIUq+qua8Pw2oESu9SUKIrPBewf3EhXnfDe4a37UV5SI9l0EFusqYlafRToC/qtE9NjpfCoUd9hdxPpWDjYd2rK4oYgaHWtkvpt+kxKJO0apZImZTdYT9+5Ut9LcugXFwvoRGADa/Kvj2HgNi7M8nypu4S3Fw2+3YJdH+P7jScLEKXD6dzWCyObFYgrWypP7hPJKp3l77r5MwWj3gHhO59KEwbM0wk+DZrinhK90VBIzopqon04zncPYKz1k8NfwW122g7FSxdgSop7LvgWA3HIFxk/qHRjYo9ziLH9d/F0DfMQoFl/SASbcHWWEWKhYNLEwECgYEA4x5Z+DFUGbG9/MKNqZS9FAVAIgCjKspg9/lf/uK6eWc2v4716H+pIRtsACKvMIxxj4i4ceSZPSyyl1z9uGiGSFbUzUuF0GWiDwaJ/2n6s+tTQgO+uIE2uxoHQpJBgG3dvcM0SKyhwf7vHz3YleP+94VW9mHUvS95CwD1gvMYEKECgYEAykd68BdTWrWbGEOkviZD/dr/QkEMVuxwrdB1Y5gAw4GVoTahr3NXf9I2Xv/CP7YZTW9oGp0l7No6OHGDgNF/yBUb9uXaZncIcb1qtmOiZNzmTnYBrzJWXq79RIpsLB/sCbsbDsLo9gxpx+13dv7Nhxh/mB3BtWXvay/hYECHgr0CgYAqPM7GlYXqcV+/zf7CduLjAkb3C99Mae62ry3nHQtI4KUR4uhgoL03Zv4i2FB0WuoTo32J0NWext0/wQ9+aBHxChTxSQZNx1joKnMniPIS28TUFhY2AfHHwgNvofuEguomDFOA4HoEtgCKctoApjIYnjeaAn+p31ZHcZo3DDaBgQKBgQDGhExU4K9/cIeb0pcVvnwv4QNuxGQV0snq65Cpg34MYVq18uXPSMVwvp95sEu1N0OxyUpEBEI6JxnIVy8V94UOmhjtwDsNIHj7F0hpY3L2xgyIqCuTAzXciqQo5iivTUzbZ/NwEz2KbDhMa/M4p2yRzys54MpA+p9zdHQdgHb9iQKBgGpHySssiYc4rcYmEzY5u3uIpT4k5kl4Ahr6a0JzJm4UXNcyiNdL2NbQaDIbfn0s8pqLvxEVtzNAh5YBXO/MF97C/uuMMbDOZuITYYGDLcNIY8gWButC1myzgrLjXhTlIxP3OQFVGz8xsxewuqcMDwhAiHXxgWapyklqUXEQIEHG',
        'log' => [
            'file' => storage_path('logs/alipay.log'),
        ],
    ],
    'wechar' => [
        'app_id' => 'wxb0f8ca1c4347edff',
        'mch_id' => '1499492312',
        'key' => '3rrpfgetx0bwopuxalcvmro5cufdgtzw',
        'cert_clien' => resource_path('wechat_pay/apiclient_cert.pem'),
        'cert_key' => resource_path('wechat_pay/apiclient_key.pem'),
        'log' => [
            'file' => storage_path('logs/wechat_pay.log'),
        ],
    ],
];
