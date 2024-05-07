<?php
// Obtener el protocolo (http o https)
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';

// Obtener el dominio (nombre de host)
$domain = $_SERVER['HTTP_HOST'];

// Obtener la URL base completa
$base_url = $protocol . '://' . $domain;

// Imprimir la URL base
//echo $base_url;
?>

<head>

   <link rel="apple-touch-icon" href="sysadmin/<?php echo str_replace("../..", "", get_row('perfil', 'logo_url', 'id_perfil', '1')) ?>">
   <link rel="shortcut icon" type="image/x-icon" href="sysadmin/<?php echo str_replace("../..", "", get_row('perfil', 'logo_url', 'id_perfil', '1')) ?>">
   <meta name="title" content="<?php echo get_row('perfil', 'nombre_empresa', 'id_perfil', '1') ?>">
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width,initial-scale=1">
   <meta name="theme-color" content="">
   <title>
      <?php echo get_row('perfil', 'nombre_empresa', 'id_perfil', '1') ?>
   </title>
   <meta property="og:site_name" content="<?php echo get_row('perfil', 'nombre_empresa', 'id_perfil', '1') ?>">
   <meta property="og:url" content="<?php echo $base_url; ?>">
   <meta property="og:title" content="<?php echo $nombre_producto; ?>">
   <meta property="og:type" content="website">
   <meta property="og:description" content="<?php echo $descripcion_producto; ?>">
   <meta property="og:image" content="<?php echo $base_url; ?>/sysadmin/<?php echo str_replace("../..", "", $image_path) ?>">
   <meta name="twitter:card" content="summary_large_image">
   <meta name="twitter:title" content="<?php echo $nombre_producto; ?>">
   <meta name="twitter:description" content="<?php echo $descripcion_producto; ?>">
   <script src="js/constants.js" type="text/javascript"></script>
   <script src="js/pubsub.js" type="text/javascript"></script>
   <script src="ccs/global.js?v=109375932537224137121693673628" defer="defer"></script>
   <!--script src="ccs/jquery.js?v=109375932537224137121693673628"  defer="defer"></script-->
   <script src="ccs/slick.min.js?v=71779134894361685811693673629" defer="defer"></script>
   <script id="sections-script" data-sections="header,footer" defer="defer" src="//tiendamiaec.com/cdn/shop/t/3/compiled_assets/scripts.js?84"></script>
   <style id="shopify-dynamic-checkout-cart">
      @media screen and (min-width: 750px) {}
   </style>
   <link href="ccs/style_ini.css" rel="stylesheet" type="text/css" />
   <link href="ccs/base.css?v=108207397045790613361693673626" rel="stylesheet" type="text/css" media="all" />

   <?php
   $sql = "select * from pixel";
   $query = mysqli_query($conexion, $sql);
   $row = mysqli_fetch_array($query);
   ?>
   <script>
      document.documentElement.className = document.documentElement.className.replace('no-js', 'js');
      if (Shopify.designMode) {
         document.documentElement.classList.add('shopify-design-mode');
      }
   </script>
   <script>
      window.bucksCC = window.bucksCC || {};
      window.bucksCC.config = {};
      window.bucksCC.reConvert = function() {};
      "function" != typeof Object.assign && (Object.assign = function(n) {
         if (null == n) throw new TypeError("Cannot convert undefined or null to object");
         for (var r = Object(n), t = 1; t < arguments.length; t++) {
            var e = arguments[t];
            if (null != e)
               for (var o in e) e.hasOwnProperty(o) && (r[o] = e[o])
         }
         return r
      });
      Object.assign(window.bucksCC.config, {
         "expertSettings": "{\"css\":\"\"}",
         "_id": "63b1a3855e8fc3681ee509d0",
         "shop": "088f7b.myshopify.com",
         "active": false,
         "autoSwitchCurrencyLocationBased": true,
         "autoSwitchOnlyToPreferredCurrency": false,
         "backgroundColor": "rgba(255,255,255,1)",
         "borderStyle": "boxShadow",
         "cartNotificationBackgroundColor": "rgba(251,245,245,1)",
         "cartNotificationMessage": "We process all orders in {STORE_CURRENCY} and you will be checkout using the most current exchange rates.",
         "cartNotificationStatus": false,
         "cartNotificationTextColor": "rgba(30,30,30,1)",
         "customOptionsPlacement": false,
         "customOptionsPlacementMobile": false,
         "customPosition": "header a[href*=\"/cart\"]",
         "darkMode": false,
         "defaultCurrencyRounding": false,
         "displayPosition": "bottom_left",
         "displayPositionType": "floating",
         "flagDisplayOption": "showFlagAndCurrency",
         "flagStyle": "traditional",
         "flagTheme": "rounded",
         "hoverColor": "rgba(255,255,255,1)",
         "instantLoader": false,
         "mobileCustomPosition": "header a[href*=\"/cart\"]",
         "mobileDisplayPosition": "bottom_left",
         "mobileDisplayPositionType": "floating",
         "mobilePositionPlacement": "after",
         "moneyWithCurrencyFormat": true,
         "optionsPlacementType": "left_upwards",
         "optionsPlacementTypeMobile": "left_upwards",
         "positionPlacement": "after",
         "priceRoundingType": "roundToDecimal",
         "roundingDecimal": 0.95,
         "selectedCurrencies": "[{\"USD\":\"US Dollar (USD)\"},{\"EUR\":\"Euro (EUR)\"},{\"GBP\":\"British Pound (GBP)\"},{\"CAD\":\"Canadian Dollar (CAD)\"},{\"AFN\":\"Afghan Afghani (AFN)\"},{\"ALL\":\"Albanian Lek (ALL)\"},{\"DZD\":\"Algerian Dinar (DZD)\"},{\"AOA\":\"Angolan Kwanza (AOA)\"},{\"ARS\":\"Argentine Peso (ARS)\"},{\"AMD\":\"Armenian Dram (AMD)\"},{\"AWG\":\"Aruban Florin (AWG)\"},{\"AUD\":\"Australian Dollar (AUD)\"},{\"BBD\":\"Barbadian Dollar (BBD)\"},{\"AZN\":\"Azerbaijani Manat (AZN)\"},{\"BDT\":\"Bangladeshi Taka (BDT)\"},{\"BSD\":\"Bahamian Dollar (BSD)\"},{\"BHD\":\"Bahraini Dinar (BHD)\"},{\"BIF\":\"Burundian Franc (BIF)\"},{\"BYN\":\"Belarusian Ruble (BYN)\"},{\"BYR\":\"Belarusian Ruble (BYR)\"},{\"BZD\":\"Belize Dollar (BZD)\"},{\"BMD\":\"Bermudan Dollar (BMD)\"},{\"BTN\":\"Bhutanese Ngultrum (BTN)\"},{\"BAM\":\"Bosnia-Herzegovina Convertible Mark (BAM)\"},{\"BRL\":\"Brazilian Real (BRL)\"},{\"BOB\":\"Bolivian Boliviano (BOB)\"},{\"BWP\":\"Botswanan Pula (BWP)\"},{\"BND\":\"Brunei Dollar (BND)\"},{\"BGN\":\"Bulgarian Lev (BGN)\"},{\"MMK\":\"Myanmar Kyat (MMK)\"},{\"KHR\":\"Cambodian Riel (KHR)\"},{\"CVE\":\"Cape Verdean Escudo (CVE)\"},{\"KYD\":\"Cayman Islands Dollar (KYD)\"},{\"XAF\":\"Central African CFA Franc (XAF)\"},{\"CLP\":\"Chilean Peso (CLP)\"},{\"CNY\":\"Chinese Yuan (CNY)\"},{\"COP\":\"Colombian Peso (COP)\"},{\"KMF\":\"Comorian Franc (KMF)\"},{\"CDF\":\"Congolese Franc (CDF)\"},{\"CRC\":\"Costa Rican Colón (CRC)\"},{\"HRK\":\"Croatian Kuna (HRK)\"},{\"CZK\":\"Czech Koruna (CZK)\"},{\"DKK\":\"Danish Krone (DKK)\"},{\"DJF\":\"Djiboutian Franc (DJF)\"},{\"DOP\":\"Dominican Peso (DOP)\"},{\"XCD\":\"East Caribbean Dollar (XCD)\"},{\"EGP\":\"Egyptian Pound (EGP)\"},{\"ETB\":\"Ethiopian Birr (ETB)\"},{\"FKP\":\"Falkland Islands Pound (FKP)\"},{\"XPF\":\"CFP Franc (XPF)\"},{\"FJD\":\"Fijian Dollar (FJD)\"},{\"GIP\":\"Gibraltar Pound (GIP)\"},{\"GMD\":\"Gambian Dalasi (GMD)\"},{\"GHS\":\"Ghanaian Cedi (GHS)\"},{\"GTQ\":\"Guatemalan Quetzal (GTQ)\"},{\"GYD\":\"Guyanaese Dollar (GYD)\"},{\"GEL\":\"Georgian Lari (GEL)\"},{\"GNF\":\"Guinean Franc (GNF)\"},{\"HTG\":\"Haitian Gourde (HTG)\"},{\"HNL\":\"Honduran Lempira (HNL)\"},{\"HKD\":\"Hong Kong Dollar (HKD)\"},{\"HUF\":\"Hungarian Forint (HUF)\"},{\"ISK\":\"Icelandic Króna (ISK)\"},{\"INR\":\"Indian Rupee (INR)\"},{\"IDR\":\"Indonesian Rupiah (IDR)\"},{\"ILS\":\"Israeli New Shekel (ILS)\"},{\"IRR\":\"Iranian Rial (IRR)\"},{\"IQD\":\"Iraqi Dinar (IQD)\"},{\"JMD\":\"Jamaican Dollar (JMD)\"},{\"JPY\":\"Japanese Yen (JPY)\"},{\"JEP\":\"Jersey Pound (JEP)\"},{\"JOD\":\"Jordanian Dinar (JOD)\"},{\"KZT\":\"Kazakhstani Tenge (KZT)\"},{\"KES\":\"Kenyan Shilling (KES)\"},{\"KWD\":\"Kuwaiti Dinar (KWD)\"},{\"KGS\":\"Kyrgystani Som (KGS)\"},{\"LAK\":\"Laotian Kip (LAK)\"},{\"LVL\":\"Latvian Lats (LVL)\"},{\"LBP\":\"Lebanese Pound (LBP)\"},{\"LSL\":\"Lesotho Loti (LSL)\"},{\"LRD\":\"Liberian Dollar (LRD)\"},{\"LYD\":\"Libyan Dinar (LYD)\"},{\"MGA\":\"Malagasy Ariary (MGA)\"},{\"MKD\":\"Macedonian Denar (MKD)\"},{\"MOP\":\"Macanese Pataca (MOP)\"},{\"MWK\":\"Malawian Kwacha (MWK)\"},{\"MVR\":\"Maldivian Rufiyaa (MVR)\"},{\"MXN\":\"Mexican Peso (MXN)\"},{\"MYR\":\"Malaysian Ringgit (MYR)\"},{\"MUR\":\"Mauritian Rupee (MUR)\"},{\"MDL\":\"Moldovan Leu (MDL)\"},{\"MAD\":\"Moroccan Dirham (MAD)\"},{\"MNT\":\"Mongolian Tugrik (MNT)\"},{\"MZN\":\"Mozambican Metical (MZN)\"},{\"NAD\":\"Namibian Dollar (NAD)\"},{\"NPR\":\"Nepalese Rupee (NPR)\"},{\"ANG\":\"Netherlands Antillean Guilder (ANG)\"},{\"NZD\":\"New Zealand Dollar (NZD)\"},{\"NIO\":\"Nicaraguan Córdoba (NIO)\"},{\"NGN\":\"Nigerian Naira (NGN)\"},{\"NOK\":\"Norwegian Krone (NOK)\"},{\"OMR\":\"Omani Rial (OMR)\"},{\"PAB\":\"Panamanian Balboa (PAB)\"},{\"PKR\":\"Pakistani Rupee (PKR)\"},{\"PGK\":\"Papua New Guinean Kina (PGK)\"},{\"PYG\":\"Paraguayan Guarani (PYG)\"},{\"PEN\":\"Peruvian Sol (PEN)\"},{\"PHP\":\"Philippine Piso (PHP)\"},{\"PLN\":\"Polish Zloty (PLN)\"},{\"QAR\":\"Qatari Rial (QAR)\"},{\"RON\":\"Romanian Leu (RON)\"},{\"RUB\":\"Russian Ruble (RUB)\"},{\"RWF\":\"Rwandan Franc (RWF)\"},{\"WST\":\"Samoan Tala (WST)\"},{\"SHP\":\"St. Helena Pound (SHP)\"},{\"SAR\":\"Saudi Riyal (SAR)\"},{\"STD\":\"São Tomé & Príncipe Dobra (STD)\"},{\"RSD\":\"Serbian Dinar (RSD)\"},{\"SCR\":\"Seychellois Rupee (SCR)\"},{\"SLL\":\"Sierra Leonean Leone (SLL)\"},{\"SGD\":\"Singapore Dollar (SGD)\"},{\"SDG\":\"Sudanese Pound (SDG)\"},{\"SYP\":\"Syrian Pound (SYP)\"},{\"ZAR\":\"South African Rand (ZAR)\"},{\"KRW\":\"South Korean Won (KRW)\"},{\"SSP\":\"South Sudanese Pound (SSP)\"},{\"SBD\":\"Solomon Islands Dollar (SBD)\"},{\"LKR\":\"Sri Lankan Rupee (LKR)\"},{\"SRD\":\"Surinamese Dollar (SRD)\"},{\"SZL\":\"Swazi Lilangeni (SZL)\"},{\"SEK\":\"Swedish Krona (SEK)\"},{\"CHF\":\"Swiss Franc (CHF)\"},{\"TWD\":\"New Taiwan Dollar (TWD)\"},{\"THB\":\"Thai Baht (THB)\"},{\"TJS\":\"Tajikistani Somoni (TJS)\"},{\"TZS\":\"Tanzanian Shilling (TZS)\"},{\"TOP\":\"Tongan Paʻanga (TOP)\"},{\"TTD\":\"Trinidad & Tobago Dollar (TTD)\"},{\"TND\":\"Tunisian Dinar (TND)\"},{\"TRY\":\"Turkish Lira (TRY)\"},{\"TMT\":\"Turkmenistani Manat (TMT)\"},{\"UGX\":\"Ugandan Shilling (UGX)\"},{\"UAH\":\"Ukrainian Hryvnia (UAH)\"},{\"AED\":\"United Arab Emirates Dirham (AED)\"},{\"UYU\":\"Uruguayan Peso (UYU)\"},{\"UZS\":\"Uzbekistani Som (UZS)\"},{\"VUV\":\"Vanuatu Vatu (VUV)\"},{\"VEF\":\"Venezuelan Bolívar (VEF)\"},{\"VND\":\"Vietnamese Dong (VND)\"},{\"XOF\":\"West African CFA Franc (XOF)\"},{\"YER\":\"Yemeni Rial (YER)\"},{\"ZMW\":\"Zambian Kwacha (ZMW)\"}]",
         "showCurrencyCodesOnly": false,
         "showInDesktop": true,
         "showInMobileDevice": false,
         "showOriginalPriceOnMouseHover": false,
         "textColor": "rgba(30,30,30,1)",
         "themeType": "default",
         "trigger": "",
         "userCurrency": "",
         "watchUrls": ""
      }, {
         money_format: "${{amount}}",
         money_with_currency_format: "${{amount}} USD",
         userCurrency: "USD"
      });
      window.bucksCC.config.multiCurrencies = [];
      window.bucksCC.config.multiCurrencies = "USD".split(',') || '';
      window.bucksCC.config.cartCurrency = "USD" || '';
   </script>
   <!-- BEGIN app block: shopify://apps/releasit-cod-form-upsells/blocks/app-embed/72faf214-4174-4fec-886b-0d0e8d3af9a2 -->


   <!-- BEGIN app snippet: metafields-handlers -->
   <style>
      h3 #_rsi-buy-now-button {
         display: none !important
      }
   </style>
   <script src="https://cdn.shopify.com/extensions/f4d444f1-c616-4248-bb30-d4abba91bf9b/0.93.0/assets/coverage-ef-ecuador.min.js" defer></script>
   <!-- END app snippet -->
   <link href="ccs/style.min.css" rel="stylesheet" type="text/css" />
   <link href="ccs/datepicker.min.css" rel="stylesheet" type="text/css" />
   <!-- END app app block -->
   <link href="https://monorail-edge.shopifysvc.com" rel="dns-prefetch">
   <!-- Meta Pixel Code -->
   <script>
      ! function(f, b, e, v, n, t, s) {
         if (f.fbq) return;
         n = f.fbq = function() {
            n.callMethod ?
               n.callMethod.apply(n, arguments) : n.queue.push(arguments)
         };
         if (!f._fbq) f._fbq = n;
         n.push = n;
         n.loaded = !0;
         n.version = '2.0';
         n.queue = [];
         t = b.createElement(e);
         t.async = !0;
         t.src = v;
         s = b.getElementsByTagName(e)[0];
         s.parentNode.insertBefore(t, s)
      }(window, document, 'script',
         'https://connect.facebook.net/en_US/fbevents.js');
      //track imporsuit
      fbq('init', '1868724866850222');
      fbq('init', '<?php echo $row['pixel'] ?>');
      fbq('track', 'PageView');
      fbq('track', 'ViewContent');
   </script>
</head>