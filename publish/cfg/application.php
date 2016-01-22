<?
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/MySQLClass.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/phpQuery.php');

class app{

    function __construct(){
        $connection = new Connection();
        $this->mysql = $connection->config();
    }
   // рандомный рефер 
   public function random_refer(){
     $refer_array = array(
        "http://yandex.ru/search/?lr=49&text=%D0%BD%D0%B5%D0%B4%D0%B2%D0%B8%D0%B6%D0%B8%D0%BC%D0%BE%D1%81%D1%82%D1%8C%20%D0%B2%20%D0%BF%D0%B5%D0%BD%D0%B7%D0%B5",
        "http://yandex.ru/search/?text=%D0%BF%D0%BE%D0%B4%D0%B0%D1%82%D1%8C%20%D0%BE%D0%B1%D1%8A%D1%8F%D0%B2%D0%BB%D0%B5%D0%BD%D0%B8%20%D0%B2%20%D0%BF%D0%B5%D0%BD%D0%B7%D0%B5&lr=49",
        "http://yandex.ru/search/?text=%D0%BE%D0%B1%D1%8A%D1%8F%D0%B2%D0%BB%D0%B5%D0%BD%D0%B8%D0%B5%20%D0%B2%20%20%D0%BF%D0%B5%D0%BD%D0%B7%D0%B5&lr=49",
        "http://yandex.ru/search/?text=bazarpnz.ru&lr=49",
        "http://yandex.ru/search/?text=%D0%B1%D0%B0%D0%B7%D0%B0%D1%80%D0%BF%D0%BD%D0%B7&lr=49",
        "http://yandex.ru/search/?text=%D0%B1%D0%B0%D0%B7%D0%B0%D1%80%20%D0%BF%D0%BD%D0%B7&lr=49",
        "http://yandex.ru/search/?text=%D1%81%D0%B0%D0%B9%D1%82%20%D0%BE%D0%B1%D1%8A%D1%8F%D0%B2%D0%BB%D0%B5%D0%BD%D0%B8%D0%B9%20%D0%B2%20%D0%BF%D0%B5%D0%BD%D0%B7%D0%B5&lr=49",
        "http://e58.ru/",
        "http://eis.58s.ru/",
        "http://go.mail.ru/search?fm=1&rf=e.mail.ru&q=j%2C%5Dzdktybz+gtyps",
        "http://go.mail.ru/search?q=%D0%B0%D0%B2%D1%82%D0%BE%20%D0%BF%D0%B5%D0%BD%D0%B7%D0%B0",
        "http://go.mail.ru/search?q=%D0%BA%D1%83%D0%BF%D0%B8%D1%82%D1%8C%20%D0%B4%D0%BE%D0%BC%20%D0%B2%20%D0%BF%D0%B5%D0%BD%D0%B7%D0%B5",
        "https://www.google.ru/search?q=%D0%BF%D1%89&oq=%D0%BF%D1%89&aqs=chrome..69i57j0l5.420j0j7&sourceid=chrome&es_sm=93&ie=UTF-8#newwindow=1&q=%D1%81%D0%BF%D0%B5%D1%86%D1%82%D0%B5%D1%85%D0%BD%D0%B8%D0%BA%D0%B0+%D0%BF%D0%B5%D0%BD%D0%B7%D0%B0",
        "https://www.google.ru/search?q=%D0%BF%D1%89&oq=%D0%BF%D1%89&aqs=chrome..69i57j0l5.420j0j7&sourceid=chrome&es_sm=93&ie=UTF-8#newwindow=1&q=%D0%BA%D1%83%D0%BF%D0%B8%D1%82%D1%8C+%D0%B4%D0%BE%D0%BC+%D0%B2+%D0%BF%D0%B5%D0%BD%D0%B7%D0%B5",
        "https://www.google.ru/search?q=%D0%BF%D1%89&oq=%D0%BF%D1%89&aqs=chrome..69i57j0l5.420j0j7&sourceid=chrome&es_sm=93&ie=UTF-8#newwindow=1&q=rdfhnbhs+d+gtpt",
        "https://www.google.ru/search?q=%D0%BF%D1%89&oq=%D0%BF%D1%89&aqs=chrome..69i57j0l5.420j0j7&sourceid=chrome&es_sm=93&ie=UTF-8#newwindow=1&q=%D0%BA%D1%83%D0%BF%D0%B8%D1%82%D1%8C+%D0%BA%D0%B2%D0%B0%D1%80%D1%82%D0%B8%D1%80%D1%83+%D0%B2+%D0%BF%D0%B5%D0%BD%D0%B7%D0%B5",
        "https://www.google.ru/search?q=%D0%BF%D1%89&oq=%D0%BF%D1%89&aqs=chrome..69i57j0l5.420j0j7&sourceid=chrome&es_sm=93&ie=UTF-8#newwindow=1&q=%D0%B4%D0%BE%D0%BC%D0%B0+%D0%B2+%D0%BF%D0%B5%D0%BD%D0%B7%D0%B5",
     );
     return $refer_array[rand(0,(count($refer_array)-1))];
   } 
   // ставим пробелы в заголов и текст 
   public function gap_paste($text)
    {
        $replacement_text = array('..','_ ',' ',',.','&','¨','#_');

        $pieces = explode(" ", $text);
        $word_i = rand(1,count($pieces)-1);
        

        $pieces[$word_i] .= $replacement[rand(0,(count($replacement)-1))];
        $comma_separated = implode(" ", $pieces);

    return $comma_separated;
    }
	 // генерируем проивьым образом браузер 
   public function random_user_agent() {
        $browser_strings = array(
          'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.80 Safari/537.36',
          'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.12) Gecko/20101026 Firefox/3.6.12',
          'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.8.1.7) Gecko/20070914 Firefox/2.0.0.7)',
          'Mozilla/5.0 (Windows NT 5.1; U; ru) Opera 9.00 ',
          'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.1.11) Firefox/2.0.0.11 ',
          'Mozilla/4.0 (compatible; MSIE 7.0b; Windows NT 6.0 ; .NET CLR 2.0.50215; SL Commerce Client v1.0; Tablet PC 2.0)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2; SV1; WebMoney Advisor; .NET CLR 1.1.4322; InfoPath.2; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30)',
          'Opera/9.25 (Windows NT 5.2; U; ru)',
          'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8) Gecko/20060206 Songbird/0.1',
          'Mozilla/5.0 (Windows; U; Windows NT 5.2 x64; en-US; rv:1.9a1) Gecko/20060214 Firefox/1.6a1',
          'Mozilla/4.0 (compatible; MSIE 4.01; Windows 95)',
          'Mozilla/5.0 (X11; U; FreeBSD i386; en-US; rv:1.8.1.13) Gecko/20080407 FreeBSD/7.0-PRERELEASE',
          'Opera/9.27 (Windows NT 5.1; U; ru)',
          'Windows; U; Windows NT 5.1; en-US; rv:1.4b) Gecko/20030504 Mozilla Firebird/0.5+', 
          'Mozilla/5.0 (Windows; U; WinNT4.0; en-CA; rv:0.9.4) Gecko/20011128 Netscape6/6.2.1', 
          'Mozilla/5.0 (Windows; U; WinNT4.0; en-US; rv:1.2) Gecko/20021126', 
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1) Opera 7.54 [en]', 
          'Windows; U; Windows NT 5.0; en-US; rv:1.8a) Gecko/20040416 Firefox/0.8.0+', 
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; en) Opera 8.00', 
          'Mozilla/4.0 (compatible; MSIE 7.0; Linux i686)', 
          'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.5) Gecko/20031007 Sylera/1.2.7',         
          'Mozilla/2.0 (compatible; MSIE 3.02; Windows CE; 240x320)',
          'Mozilla/4.0 (SmartPhone; Symbian OS-Series60/1.0 NetFront/3.3',
          'Mozilla/4.0 (compatible; MSIE 4.01; Windows CE; IEMobile 6.12)',
          'Mozilla/4.0 (compatible; MSIE 4.01; Windows CE; O2 Xda 2mini; PPC; 240x320)',
          'Mozilla/4.0 (compatible; MSIE 4.01; Windows CE; PPC i-mate JAMA; 240x320)',
          'Mozilla/4.0 (compatible; MSIE 4.01; Windows CE; PPC; 240x240; HP iPAQ hw6500/1.0',
          'Mozilla/4.0 (compatible; MSIE 4.01; Windows CE; PPC; 240x320)/UCWEB7.0.0.33/31/6500',
          'Mozilla/4.0 (compatible; MSIE 4.01; Windows CE; PPC; 240x320)/UCWEB7.0.2.37/31/999',
          'Mozilla/4.0 (compatible; MSIE 4.01; Windows CE; SmartPhone; 176x220) Opera 6.0',
          'Mozilla/4.0 (compatible; MSIE 4.01; Windows CE; Smartphone; 176x220)',
          'Mozilla/4.0 (compatible; MSIE 4.01; Windows CE; Smartphone; 240x320)',
          'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)',
          'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)',
          'Mozilla/4.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/5.0)',
          'Mozilla/1.22 (compatible; MSIE 10.0; Windows 3.1)',
          'Mozilla/5.0 (X11; Linux x86_64; rv:2.2a1pre) Gecko/20110324 Firefox/4.2a1pre',
          'Mozilla/5.0 (X11; Linux x86_64; rv:2.2a1pre) Gecko/20100101 Firefox/4.2a1pre',
          'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:2.2a1pre) Gecko/20110324 Firefox/4.2a1pre',
          'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:2.2a1pre) Gecko/20110323 Firefox/4.2a1pre',
          'Mozilla/5.0 (X11; Linux x86_64; rv:2.0b9pre) Gecko/20110111 Firefox/4.0b9pre',
          'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:2.0b9pre) Gecko/20101228 Firefox/4.0b9pre',
          'Mozilla/5.0 (Windows NT 5.1; rv:2.0b9pre) Gecko/20110105 Firefox/4.0b9pre',
          'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/534.25 (KHTML, like Gecko) Chrome/12.0.706.0 Safari/534.25',
          'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/534.24 (KHTML, like Gecko) Ubuntu/10.10 Chromium/12.0.703.0 Chrome/12.0.703.0 Safari/534.24',
          'Mozilla/5.0 (X11; Linux i686) AppleWebKit/534.24 (KHTML, like Gecko) Ubuntu/10.10 Chromium/12.0.702.0 Chrome/12.0.702.0 Safari/534.24',
          'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/534.24 (KHTML, like Gecko) Chrome/12.0.702.0 Safari/534.24',
          'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/534.24 (KHTML, like Gecko) Chrome/12.0.702.0 Safari/534.24',
          'Mozilla/5.0 (Windows; U; Windows NT 6.1; tr-TR) AppleWebKit/533.20.25 (KHTML, like Gecko) Version/5.0.4 Safari/533.20.27',
          'Mozilla/5.0 (Windows; U; Windows NT 6.1; ko-KR) AppleWebKit/533.20.25 (KHTML, like Gecko) Version/5.0.4 Safari/533.20.27',
          'Mozilla/5.0 (Windows; U; Windows NT 6.1; fr-FR) AppleWebKit/533.20.25 (KHTML, like Gecko) Version/5.0.4 Safari/533.20.27',
          'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/533.20.25 (KHTML, like Gecko) Version/5.0.4 Safari/533.20.27',
          'Mozilla/5.0 (Windows; U; Windows NT 6.1; cs-CZ) AppleWebKit/533.20.25 (KHTML, like Gecko) Version/5.0.4 Safari/533.20.27',
          'Opera/9.80 (Windows NT 6.0; U; en) Presto/2.8.99 Version/11.9',
          'Opera/9.80 (Windows NT 5.1; U; zh-tw) Presto/2.8.131 Version/11.10',
          'Opera/9.80 (X11; Linux x86_64; U; Ubuntu/10.10 (maverick); pl) Presto/2.7.62 Version/11.01',
          'Opera/9.80 (X11; Linux i686; U; ja) Presto/2.7.62 Version/11.01',
          'Opera/9.80 (X11; Linux i686; U; fr) Presto/2.7.62 Version/11.01',
          'Mozilla/5.0 (compatible; MSIE 7.0; Windows NT 5.0)',
          'Mozilla/5.0 (compatible; MSIE 7.0; Windows NT 5.1)',
          'Mozilla/5.0 (compatible; MSIE 7.0; Windows NT 5.2)',
          'Mozilla/5.0 (compatible; MSIE 7.0; Windows NT 6.0)',
          'Mozilla/5.0 (compatible; MSIE 7.0; Windows NT 6.1)',
          'Opera/10.00 (Windows NT 6.0; U; en) Presto/2.2.0',
          'Opera/7.23 (Windows 98; U) [en]',
          'Opera/7.51 (Windows NT 5.0; U) [en]',
          'Opera/7.51 (Windows NT 5.1; U) [ru]',
          'Opera/7.51 (Windows NT 5.2; U) [ch]',
          'Opera/7.51 (Windows NT 6.0; U) [zw]',
          'Opera/7.51 (Windows NT 6.1; U) [ua]',
          'Opera/8.0 (X11; Linux i686; U; cs)',
          'Opera/8.51 (Windows NT 5.1; U; en)',
          'Opera/9.0 (Windows NT 5.1; U; en)',
          'Opera/9.00 (Nintendo Wii; U; ; 1309-9; en)',
          'Opera/9.00 (Wii; U; ; 1038-58; Wii Shop Channel/1.0; en)',
          'Opera/9.01 (X11; Linux i686; U; en)',
          'Opera/9.02 (Windows NT 5.1; U; en)',
          'Opera/9.10 (Windows NT 5.1; U; en)',
          'Opera/9.23 (Windows NT 5.1; U; ru)',
          'Opera/9.50 (Windows NT 5.1; U; ru)',
          'Opera/9.50 (Windows NT 6.0; U; en)',
          'Opera/9.60 (Windows NT 5.1; U; en) Presto/2.1.1',
          'Opera/9.80 (Windows NT 5.1; U; en) Presto/2.5.18 Version/10.50',
          'Opera/9.80 (Windows NT 5.1; U; ru) Presto/2.2.15 Version/10.20',
          'Opera/9.80 (Windows NT 6.1; U; ru) Presto/2.2.15 Version/10.00',
          'Opera/9.80 (Windows NT 6.1; U; ru) Presto/2.9.168 Version/11.51',
          'Opera/9.80 (X11; Linux x86_64; U; en) Presto/2.2.15 Version/10.10',
          'Opera/9.80 (X11; Linux x86_64; U; ru) Presto/2.2.15 Version/10.10',
          'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; SV1; .NET CLR 2.0.50727)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)',
          'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko',
          'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko',
          'Mozilla/5.0 (Windows NT 6.1; Trident/7.0; rv:11.0) like Gecko',
          'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0)',
          'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; Trident/4.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; InfoPath.2)',
          'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0)',
          'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0)',
          'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.0; Trident/5.0)',
          'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML like Gecko) Chrome/28.0.1500.95 Safari/537.36',
          'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML like Gecko) Chrome/28.0.1500.72 Safari/537.36',
          'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML like Gecko) Chrome/28.0.1500.95 Safari/537.36',
          'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML like Gecko) Chrome/28.0.1500.95 Safari/537.36',
          'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML like Gecko) Chrome/28.0.1500.72 Safari/537.36',
          'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML like Gecko) Chrome/28.0.1500.72 Safari/537.36',
          'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML like Gecko) Chrome/28.0.1500.95 Safari/537.36',
          'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML like Gecko) Chrome/29.0.1547.66 Safari/537.36',
          'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML like Gecko) Chrome/29.0.1547.76 Safari/537.36',
          'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML like Gecko) Chrome/29.0.1547.66 Safari/537.36',
          'Mozilla/5.0 (Macintosh; Intel Mac OS X 1084) AppleWebKit/537.36 (KHTML like Gecko) Chrome/29.0.1547.65 Safari/537.36',
          'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML like Gecko) Chrome/29.0.1547.66 Safari/537.36',
          'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML like Gecko) Chrome/29.0.1547.66 Safari/537.36',
          'Mozilla/5.0 (Windows NT 6.2) AppleWebKit/537.36 (KHTML like Gecko) Chrome/29.0.1547.76 Safari/537.36',
          'Mozilla/5.0 (X11; Linux x8664) AppleWebKit/537.36 (KHTML like Gecko) Chrome/29.0.1547.65 Safari/537.36',
          'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML like Gecko) Chrome/30.0.1599.101 Safari/537.36',
          'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML like Gecko) Chrome/30.0.1599.101 Safari/537.36',
          'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML like Gecko) Chrome/30.0.1599.101 Safari/537.36',
          'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML like Gecko) Chrome/30.0.1599.101 Safari/537.36',
          'Mozilla/5.0 (Macintosh; Intel Mac OS X 1090) AppleWebKit/537.36 (KHTML like Gecko) Chrome/30.0.1599.101 Safari/537.36',
          'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML like Gecko) Chrome/30.0.1599.101 Safari/537.36',
          'Mozilla/5.0 (Windows NT 6.2) AppleWebKit/537.36 (KHTML like Gecko) Chrome/30.0.1599.101 Safari/537.36',
          'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML like Gecko) Chrome/31.0.1650.63 Safari/537.36',
          'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML like Gecko) Chrome/31.0.1650.57 Safari/537.36',
          'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML like Gecko) Chrome/31.0.1650.63 Safari/537.36',
          'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML like Gecko) Chrome/31.0.1650.63 Safari/537.36',
          'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML like Gecko) Chrome/31.0.1650.57 Safari/537.36',
          'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML like Gecko) Chrome/31.0.1650.63 Safari/537.36',
          'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML like Gecko) Chrome/31.0.1650.57 Safari/537.36',
          'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML like Gecko) Chrome/32.0.1700.107 Safari/537.36',
          'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML like Gecko) Chrome/32.0.1700.107 Safari/537.36',
          'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML like Gecko) Chrome/32.0.1700.107 Safari/537.36',
          'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML like Gecko) Chrome/32.0.1700.102 Safari/537.36',
          'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML like Gecko) Chrome/32.0.1700.102 Safari/537.36',
          'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML like Gecko) Chrome/32.0.1700.107 Safari/537.36',
          'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML like Gecko) Chrome/32.0.1700.107 Safari/537.36',
          'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML like Gecko) Chrome/33.0.1750.146 Safari/537.36',
          'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML like Gecko) Chrome/33.0.1750.117 Safari/537.36',
          'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML like Gecko) Chrome/33.0.1750.146 Safari/537.36',
          'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML like Gecko) Chrome/33.0.1750.146 Safari/537.36',
          'Mozilla/5.0 (Windows NT 6.0) AppleWebKit/537.36 (KHTML like Gecko) Chrome/33.0.1750.117 Safari/537.36',
          'Mozilla/5.0 (Macintosh; Intel Mac OS X 1091) AppleWebKit/537.36 (KHTML like Gecko) Chrome/33.0.1750.117 Safari/537.36',
          'Mozilla/5.0 (Macintosh; Intel Mac OS X 1092) AppleWebKit/537.36 (KHTML like Gecko) Chrome/33.0.1750.146 Safari/537.36',
          'Mozilla/5.0 (Windows NT 6.2) AppleWebKit/537.36 (KHTML like Gecko) Chrome/33.0.1750.117 Safari/537.36',
          'Mozilla/5.0 (X11; Linux x8664) AppleWebKit/537.36 (KHTML like Gecko) Chrome/33.0.1750.117 Safari/537.36',
          'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:21.0) Gecko/20100101 Firefox/21.0',
          'Mozilla/5.0 (Windows NT 5.1; rv:21.0) Gecko/20100101 Firefox/21.0',
          'Mozilla/5.0 (Windows NT 6.1; rv:21.0) Gecko/20100101 Firefox/21.0',
          'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:21.0) Gecko/20100101 Firefox/21.0',
          'Mozilla/5.0 (X11; Ubuntu; Linux x8664; rv:21.0) Gecko/20100101 Firefox/21.0',
          'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:22.0) Gecko/20100101 Firefox/22.0',
          'Mozilla/5.0 (Windows NT 5.1; rv:22.0) Gecko/20100101 Firefox/22.0',
          'Mozilla/5.0 (Windows NT 6.1; rv:22.0) Gecko/20100101 Firefox/22.0',
          'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:22.0) Gecko/20100101 Firefox/22.0',
          'Mozilla/5.0 (Windows NT 5.1; rv:23.0) Gecko/20100101 Firefox/23.0',
          'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:23.0) Gecko/20100101 Firefox/23.0',
          'Mozilla/5.0 (Windows NT 6.1; rv:23.0) Gecko/20100101 Firefox/23.0',
          'Mozilla/5.0 (Windows NT 6.0; rv:23.0) Gecko/20100101 Firefox/23.0',
          'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:23.0) Gecko/20100101 Firefox/23.0',
          'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:23.0) Gecko/20100101 Firefox/23.0',
          'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:25.0) Gecko/20100101 Firefox/25.0',
          'Mozilla/5.0 (Windows NT 6.1; rv:25.0) Gecko/20100101 Firefox/25.0',
          'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:25.0) Gecko/20100101 Firefox/25.0',
          'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:25.0) Gecko/20100101 Firefox/25.0',
          'Mozilla/5.0 (Windows NT 6.0; rv:25.0) Gecko/20100101 Firefox/25.0',
          'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:26.0) Gecko/20100101 Firefox/26.0',
          'Mozilla/5.0 (X11; Ubuntu; Linux x8664; rv:26.0) Gecko/20100101 Firefox/26.0',
          'Mozilla/5.0 (X11; Linux x8664; rv:26.0) Gecko/20100101 Firefox/26.0',
          'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:26.0) Gecko/20100101 Firefox/26.0 AlexaToolbar/alxf-2.19',
          'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:26.0) Gecko/20100101 Firefox/26.0',
          'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:24.0) Gecko/20100101 Firefox/24.0',
          'Mozilla/5.0 (Windows NT 6.1; rv:24.0) Gecko/20100101 Firefox/24.0',
          'Mozilla/5.0 (Windows NT 5.1; rv:24.0) Gecko/20100101 Firefox/24.0',
          'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:24.0) Gecko/20100101 Firefox/24.0',
          'Mozilla/5.0 (Windows NT 6.2; rv:24.0) Gecko/20100101 Firefox/24.0',
          'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:27.0) Gecko/20100101 Firefox/27.0',
          'Mozilla/5.0 (Windows NT 6.1; rv:27.0) Gecko/20100101 Firefox/27.0',
          'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:27.0) Gecko/20100101 Firefox/27.0',
          'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:27.0) Gecko/20100101 Firefox/27.0',
          'Mozilla/5.0 (X11; Linux x8664; rv:27.0) Gecko/20100101 Firefox/27.0',
          'Mozilla/5.0 (Macintosh; Intel Mac OS X 1084) AppleWebKit/536.30.1 (KHTML like Gecko) Version/6.0.5 Safari/536.30.1',
          'Mozilla/5.0 (Macintosh; Intel Mac OS X 1082) AppleWebKit/536.26.17 (KHTML like Gecko) Version/6.0.2 Safari/536.26.17',
          'Mozilla/5.0 (Macintosh; Intel Mac OS X 1075) AppleWebKit/536.30.1 (KHTML like Gecko) Version/6.0.5 Safari/536.30.1',
          'Mozilla/5.0 (Macintosh; Intel Mac OS X 109) AppleWebKit/537.43.7 (KHTML like Gecko) Version/7.0 Safari/537.43.7',
          'Mozilla/5.0 (Macintosh; Intel Mac OS X 1083) AppleWebKit/536.28.10 (KHTML like Gecko) Version/6.0.3 Safari/536.28.10',
          'Mozilla/5.0 (Macintosh; Intel Mac OS X 1068) AppleWebKit/534.57.2 (KHTML like Gecko) Version/5.1.7 Safari/534.57.2',
          'Mozilla/5.0 (Macintosh; Intel Mac OS X 1068) AppleWebKit/534.59.8 (KHTML like Gecko) Version/5.1.9 Safari/534.59.8',
          'Mozilla/5.0 (Macintosh; Intel Mac OS X 1068) AppleWebKit/534.59.10 (KHTML like Gecko) Version/5.1.9 Safari/534.59.10',
          'Mozilla/5.0 (Macintosh; Intel Mac OS X 1074) AppleWebKit/534.57.2 (KHTML like Gecko) Version/5.1.7 Safari/534.57.2',
          'Mozilla/5.0 (Macintosh; Intel Mac OS X 109) AppleWebKit/537.46.5 (KHTML like Gecko) Version/7.0 Safari/537.46.5',
          'Mozilla/5.0 (Macintosh; Intel Mac OS X 109) AppleWebKit/537.71 (KHTML like Gecko) Version/7.0 Safari/537.71',
          'Mozilla/5.0 (Macintosh; Intel Mac OS X 1092) AppleWebKit/537.74.9 (KHTML like Gecko) Version/7.0.2 Safari/537.74.9',
          'Mozilla/5.0 (Macintosh; Intel Mac OS X 109) AppleWebKit/537.54.1 (KHTML like Gecko) Version/7.0 Safari/537.54.1',
          'Mozilla/5.0 (Macintosh; Intel Mac OS X 109) AppleWebKit/537.66 (KHTML like Gecko) Version/7.0 Safari/537.66',
          'Mozilla/5.0 (Macintosh; Intel Mac OS X 109) AppleWebKit/537.59 (KHTML like Gecko) Version/7.0 Safari/537.59',
          'Opera/9.80 (Windows NT 6.1; WOW64) Presto/2.12 Version/12.16',
          'Opera/9.80 (Windows NT 5.1) Presto/2.12 Version/12.16',
          'Opera/9.80 (Windows NT 6.1) Presto/2.12 Version/12.16',
          'Opera/9.80 (Windows NT 6.2; WOW64) Presto/2.12 Version/12.16',
          'Opera/9.80 (X11; Linux x8664) Presto/2.12 Version/12.16',
          'Opera/9.80 (Windows NT 5.1) Presto/2.12 Version/12.15',
          'Opera/9.80 (Windows NT 6.0) Presto/2.12 Version/12.15',
          'Opera/9.80 (X11; Linux i686) Presto/2.12 Version/12.15',
          'Opera/9.80 (X11; Linux x8664) Presto/2.12 Version/12.15',
          'Opera/9.80 (Windows NT 6.1; Edition Yx) Presto/2.12 Version/12.15',
          'Opera/9.80 (Windows NT 5.1) Presto/2.12 Version/12.14',
          'Opera/9.80 (Windows NT 6.2; WOW64) Presto/2.12 Version/12.14',
          'Opera/9.80 (Windows NT 6.2) Presto/2.12 Version/12.14',
          'Opera/9.80 (X11; Linux i686) Presto/2.12 Version/12.14',
          'Opera/9.80 (Windows NT 6.1; Edition Yx) Presto/2.12 Version/12.14',
          'Opera/9.80 (Windows NT 6.1; U; ru) Presto/2.6 Version/10.63',
          'Opera/9.80 (Windows NT 6.1; U; YB/3.5; ru) Presto/2.6 Version/10.63',
          'Opera/9.80 (Windows NT 6.1; U; en) Presto/2.6 Version/10.63',
          'Opera/9.80 (Windows NT 6.1; U; MRA 5.7 (build 03686); ru) Presto/2.6 Version/10.63',
          'Opera/9.80 (Macintosh; PPC Mac OS X; U; en) Presto/2.6 Version/10.63',
          'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML like Gecko) Chrome/30.0.1599.12785 YaBrowser/13.12.1599.12785 Safari/537.36',
          'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML like Gecko) Chrome/30.0.1599.13014 YaBrowser/13.12.1599.13014 Safari/537.36',
          'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML like Gecko) Chrome/30.0.1599.13014 YaBrowser/13.12.1599.13014 Safari/537.36',
          'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML like Gecko) Chrome/30.0.1599.12785 YaBrowser/13.12.1599.12785 Safari/537.36',
          'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML like Gecko) Chrome/30.0.1599.12124 YaBrowser/13.12.1599.12124 Safari/537.36',
          'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML like Gecko) Chrome/30.0.1599.13014 YaBrowser/13.12.1599.13014 Safari/537.36',
          'Mozilla/5.0 (Macintosh; Intel Mac OS X 1091) AppleWebKit/537.36 (KHTML like Gecko) Chrome/28.0.1500.95 YaBrowser/13.10.1500.9322 Safari/537.36',
          'Mozilla/5.0 (Macintosh; Intel Mac OS X 1090) AppleWebKit/537.36 (KHTML like Gecko) Chrome/28.0.1500.95 YaBrowser/13.10.1500.9322 Safari/537.36',
          'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML like Gecko) Chrome/28.0.1500.95 YaBrowser/13.10.1500.8299 Safari/537.36',
          'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML like Gecko) Chrome/28.0.1500.95 YaBrowser/13.10.1500.9323 Safari/537.36',
          'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML like Gecko) Chrome/28.0.1500.95 YaBrowser/13.10.1500.9323 Safari/537.36',
          'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML like Gecko) Chrome/28.0.1500.95 YaBrowser/13.10.1500.9323 Safari/537.36',
          'Mozilla/5.0 (Windows NT 6.0) AppleWebKit/537.36 (KHTML like Gecko) Chrome/28.0.1500.95 YaBrowser/13.10.1500.9323 Safari/537.36',
          'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML like Gecko) Chrome/28.0.1500.95 YaBrowser/13.10.1500.9151 Safari/537.36',
          'Mozilla/5.0 (X11; Linux x8664) AppleWebKit/537.36 (KHTML like Gecko) Ubuntu Chromium/28.0.1500.52 Chrome/28.0.1500.52 Safari/537.36',
          'Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.36 (KHTML like Gecko) Ubuntu Chromium/28.0.1500.52 Chrome/28.0.1500.52 Safari/537.36',
          'Mozilla/5.0 (X11; Linux x8664) AppleWebKit/537.36 (KHTML like Gecko) Ubuntu Chromium/28.0.1500.71 Chrome/28.0.1500.71 Safari/537.36',
          'Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.36 (KHTML like Gecko) Ubuntu Chromium/28.0.1500.71 Chrome/28.0.1500.71 Safari/537.36',
          'Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.36 (KHTML like Gecko) Ubuntu Chromium/31.0.1650.63 Chrome/31.0.1650.63 Safari/537.36',
          'Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.36 (KHTML like Gecko) Ubuntu Chromium/30.0.1599.114 Chrome/30.0.1599.114 Safari/537.36',
          'Mozilla/5.0 (X11; Linux x8664) AppleWebKit/537.36 (KHTML like Gecko) Ubuntu Chromium/30.0.1599.114 Chrome/30.0.1599.114 Safari/537.36',
          'Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.22 (KHTML like Gecko) Ubuntu Chromium/25.0.1364.160 Chrome/25.0.1364.160 Safari/537.22',
          'Mozilla/5.0 (X11; U; Linux x86_64; en-US) AppleWebKit/534.13 (KHTML, like Gecko) Chrome/9.0.597.0 Safari/534.13',
          'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.13 (KHTML, like Gecko) Chrome/9.0.597.0 Safari/534.13',
          'Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US) AppleWebKit/534.13 (KHTML, like Gecko) Chrome/9.0.597.0 Safari/534.13',
          'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/534.13 (KHTML, like Gecko) Chrome/9.0.597.0 Safari/534.13',
          'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_5; en-US) AppleWebKit/534.13 (KHTML, like Gecko) Chrome/9.0.597.0 Safari/534.13',
          'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_4; en-US) AppleWebKit/534.13 (KHTML, like Gecko) Chrome/9.0.597.0 Safari/534.13',
          'Mozilla/5.0 (Windows; U; Windows NT 6.1; de-DE) AppleWebKit/534.10 (KHTML, like Gecko) Chrome/8.0.552.224 Safari/534.10',
          'Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US) AppleWebKit/533.3 (KHTML, like Gecko) Chrome/8.0.552.224 Safari/533.3',
          'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_8; en-US) AppleWebKit/534.10 (KHTML, like Gecko) Chrome/8.0.552.224 Safari/534.10',
          'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_8; en-US) AppleWebKit/534.10 (KHTML, like Gecko) Chrome/8.0.552.224 Safari/534.10',
          'Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.1.15) Gecko/20101027 Mozilla/5.0 (Windows; U; Windows NT 5.2; en-US) AppleWebKit/534.10 (KHTML, like Gecko) Chrome/7.0.540.0 Safari/534.10',
          'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.10 (KHTML, like Gecko) Chrome/7.0.540.0 Safari/534.10',
          'Mozilla/5.0 (Windows; U; Windows NT 6.1; de-DE) AppleWebKit/534.10 (KHTML, like Gecko) Chrome/7.0.540.0 Safari/534.10',
          'Mozilla/5.0 (Windows; U; Windows NT 5.2; en-US) AppleWebKit/534.10 (KHTML, like Gecko) Chrome/7.0.540.0 Safari/534.10',
          'Mozilla/5.0 (X11; U; Linux x86_64; fr-FR) AppleWebKit/534.7 (KHTML, like Gecko) Chrome/7.0.514.0 Safari/534.7',
          'Mozilla/5.0 (X11; U; Linux x86_64; en-US) AppleWebKit/534.7 (KHTML, like Gecko) Chrome/7.0.514.0 Safari/534.7',
          'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/534.7 (KHTML, like Gecko) Chrome/7.0.514.0 Safari/534.7',
          'Mozilla/5.0 (X11; U; Linux x86_64; en-US) AppleWebKit/534.3 (KHTML, like Gecko) Chrome/6.0.458.1 Safari/534.3',
          'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.3 (KHTML, like Gecko) Chrome/6.0.458.1 Safari/534.3',
          'Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US) AppleWebKit/534.3 (KHTML, like Gecko) Chrome/6.0.458.1 Safari/534.3',
          'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/534.3 (KHTML, like Gecko) Chrome/6.0.458.1 Safari/534.3',
          'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_4; en-US) AppleWebKit/534.3 (KHTML, like Gecko) Chrome/6.0.458.1 Safari/534.3',
          'Mozilla/5.0 (X11; U; Linux i686; en-US) AppleWebKit/534.1 SUSE/6.0.428.0 (KHTML, like Gecko) Chrome/6.0.428.0 Safari/534.1',
          'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.1 (KHTML, like Gecko) Chrome/6.0.428.0 Safari/534.1',
          'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-GB) AppleWebKit/534.1 (KHTML, like Gecko) Chrome/6.0.428.0 Safari/534.1',
          'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_3; en-US) AppleWebKit/534.1 (KHTML, like Gecko) Chrome/6.0.428.0 Safari/534.1',
          'Mozilla/5.0 (X11; U; Linux x86_64; en-US) AppleWebKit/533.4 (KHTML, like Gecko) Chrome/5.0.375.99 Safari/533.4',
          'Mozilla/5.0 (Windows; U; Windows NT 5.2; en-US) AppleWebKit/533.4 (KHTML, like Gecko) Chrome/5.0.375.99 Safari/533.4',
          'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_2; en-US) AppleWebKit/533.4 (KHTML, like Gecko) Chrome/5.0.375.99 Safari/533.4',
          'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_0; en-US) AppleWebKit/533.4 (KHTML, like Gecko) Chrome/5.0.375.99 Safari/533.4',
          'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_6; en-US) AppleWebKit/533.4 (KHTML, like Gecko) Chrome/5.0.375.99 Safari/533.4',
          'Mozilla/5.0 (X11; U; Linux x86_64; en-US) AppleWebKit/532.2 (KHTML, like Gecko) Chrome/4.0.223.2 Safari/532.2',
          'Mozilla/5.0 (X11; U; Linux i686; en-US) AppleWebKit/532.2 (KHTML, like Gecko) Chrome/4.0.223.2 Safari/532.2',
          'Mozilla/5.0 (Windows; U; Windows NT 5.2; en-US) AppleWebKit/532.2 (KHTML, like Gecko) Chrome/4.0.223.2 Safari/532.2',
          'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/532.2 (KHTML, like Gecko) Chrome/4.0.223.2 Safari/532.2',
          'Mozilla/5.0 (X11; U; Linux x86_64; en-US) AppleWebKit/532.2 (KHTML, like Gecko) Chrome/4.0.222.5 Safari/532.2',
          'Mozilla/5.0 (X11; U; Linux i686; en-US) AppleWebKit/532.2 (KHTML, like Gecko) Chrome/4.0.222.5 Safari/532.2',
          'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/532.2 (KHTML, like Gecko) Chrome/4.0.222.5 Safari/532.2',
          'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_8; en-US) AppleWebKit/532.2 (KHTML, like Gecko) Chrome/4.0.222.5 Safari/532.2',
          'Opera/9.80 (Android; Linux; Opera Mobi/ADR-1012221546; U; pl) Presto/2.7.60 Version/10.5',
          'Opera/9.80 (Android 2.2;;; Linux; Opera Mobi/ADR-1012291359; U; en) Presto/2.7.60 Version/10.5',
          'Opera/9.80 (Android 2.2; Opera Mobi/ADR-2093533608; U; pl) Presto/2.7.60 Version/10.5',
          'Opera/9.80 (Android 2.2; Opera Mobi/-2118645896; U; pl) Presto/2.7.60 Version/10.5',
          'Opera/9.80 (Android 2.2; Linux; Opera Mobi/ADR-2093533312; U; pl) Presto/2.7.60 Version/10.5',
          'Opera/9.80 (Android 2.2; Linux; Opera Mobi/ADR-2093533120; U; pl) Presto/2.7.60 Version/10.5',
          'Opera/9.80 (Android 2.2; Linux; Opera Mobi/8745; U; en) Presto/2.7.60 Version/10.5',
          'Opera/9.80 (S60; SymbOS; Opera Mobi/1209; U; sk) Presto/2.5.28 Version/10.1',
          'Opera/9.80 (S60; SymbOS; Opera Mobi/1209; U; fr) Presto/2.5.28 Version/10.1',
          'Opera/9.80 (S60; SymbOS; Opera Mobi/1181; U; en-GB) Presto/2.5.28 Version/10.1',
          'Opera/9.80 (Android; Linux; Opera Mobi/ADR-1012211514; U; en) Presto/2.6.35 Version/10.1',
          'Opera/9.80 (Android; Linux; Opera Mobi/ADR-1011151731; U; de) Presto/2.5.28 Version/10.1',
          'Opera/9.80 (Windows NT 6.1; Opera Mobi/49; U; en) Presto/2.4.18 Version/10.00',
          'Opera/9.80 (Windows NT 6.0; Opera Mobi/49; U; en) Presto/2.4.18 Version/10.00',
          'Opera/9.80 (Windows NT 5.1; Opera Mobi/49; U; en) Presto/2.4.18 Version/10.00',
          'Opera/9.80 (Windows Mobile; WCE; Opera Mobi/49; U; en) Presto/2.4.18 Version/10.00',
          'Opera/9.80 (Macintosh; Intel Mac OS X; Opera Mobi/3730; U; en) Presto/2.4.18 Version/10.00',
          'Opera/9.80 (Macintosh; Intel Mac OS X; Opera Mobi/27; U; en) Presto/2.4.18 Version/10.00',
          'Opera/9.80 (Linux i686; Opera Mobi/1040; U; en) Presto/2.5.24 Version/10.00',
          'Opera/9.80 (Linux i686; Opera Mobi/1038; U; en) Presto/2.5.24 Version/10.00',
          'Opera/9.80 (Android; Linux; Opera Mobi/49; U; en) Presto/2.4.18 Version/10.00',
          'Opera/9.80 (Android; Linux; Opera Mobi/27; U; en) Presto/2.4.18 Version/10.00',
          'Mozilla/5.0 (S60; SymbOS; Opera Mobi/SYB-1103211396; U; es-LA; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6 Opera 11.00',
          'Mozilla/5.0 (S60; SymbOS; Opera Mobi/1209; U; it; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6 Opera 10.1',
          'Mozilla/5.0 (S60; SymbOS; Opera Mobi/1181; U; en-GB; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6 Opera 10.1',
          'Mozilla/5.0 (Linux armv7l; Maemo; Opera Mobi/4; U; fr; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6 Opera 10.1',
          'Mozilla/5.0 (Linux armv6l; Maemo; Opera Mobi/8; U; en-GB; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6 Opera 11.00',
          'Mozilla/5.0 (Android 2.2.2; Linux; Opera Mobi/ADR-1103311355; U; en; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6 Opera 11.00',
          'Mozilla/4.0 (compatible; MSIE 8.0; S60; SymbOS; Opera Mobi/SYB-1107071606; en) Opera 11.10',
          'Mozilla/4.0 (compatible; MSIE 8.0; Linux armv7l; Maemo; Opera Mobi/4; fr) Opera 10.1',
          'Mozilla/4.0 (compatible; MSIE 8.0; Linux armv6l; Maemo; Opera Mobi/8; en-GB) Opera 11.00',
          'Mozilla/4.0 (compatible; MSIE 8.0; Android 2.2.2; Linux; Opera Mobi/ADR-1103311355; en) Opera 11.00',
          'Mozilla/5.0 (Windows; U; Windows NT 6.1; zh-HK) AppleWebKit/533.18.1 (KHTML, like Gecko) Version/5.0.2 Safari/533.18.5',
          'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/533.19.4 (KHTML, like Gecko) Version/5.0.2 Safari/533.18.5',
          'Mozilla/5.0 (Windows; U; Windows NT 6.0; tr-TR) AppleWebKit/533.18.1 (KHTML, like Gecko) Version/5.0.2 Safari/533.18.5',
          'Mozilla/5.0 (Windows; U; Windows NT 6.0; nb-NO) AppleWebKit/533.18.1 (KHTML, like Gecko) Version/5.0.2 Safari/533.18.5',
          'Mozilla/5.0 (Windows; U; Windows NT 6.0; fr-FR) AppleWebKit/533.18.1 (KHTML, like Gecko) Version/5.0.2 Safari/533.18.5',
          'Mozilla/5.0 (Windows; U; Windows NT 5.1; zh-TW) AppleWebKit/533.19.4 (KHTML, like Gecko) Version/5.0.2 Safari/533.18.5',
          'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru-RU) AppleWebKit/533.18.1 (KHTML, like Gecko) Version/5.0.2 Safari/533.18.5',
          'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_8; zh-cn) AppleWebKit/533.18.1 (KHTML, like Gecko) Version/5.0.2 Safari/533.18.5',
          'Mozilla/5.0 (iPod; U; CPU iPhone OS 4_3_3 like Mac OS X; ja-jp) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5',
          'Mozilla/5.0 (iPod; U; CPU iPhone OS 4_3_1 like Mac OS X; zh-cn) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8G4 Safari/6533.18.5',
          'Mozilla/5.0 (iPod; U; CPU iPhone OS 4_2_1 like Mac OS X; he-il) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8C148 Safari/6533.18.5',
          'Mozilla/5.0 (iPhone; U; ru; CPU iPhone OS 4_2_1 like Mac OS X; ru) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8C148a Safari/6533.18.5',
          'Mozilla/5.0 (iPhone; U; ru; CPU iPhone OS 4_2_1 like Mac OS X; fr) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8C148a Safari/6533.18.5',
          'Mozilla/5.0 (iPhone; U; fr; CPU iPhone OS 4_2_1 like Mac OS X; fr) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8C148a Safari/6533.18.5',
          'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_3_1 like Mac OS X; zh-tw) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8G4 Safari/6533.18.5',
          'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_3 like Mac OS X; fr-fr) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8F190 Safari/6533.18.5',
          'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_3 like Mac OS X; en-gb) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8F190 Safari/6533.18.5',
          'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_2_1 like Mac OS X; ru-ru) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8C148 Safari/6533.18.5',
          'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_2_1 like Mac OS X; nb-no) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8C148a Safari/6533.18.5',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322; FDM)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0; Avant Browser [avantbrowser.com]; Hotbar 4.4.5.0)',
          'Mozilla/4.61 [en] (X11; U; ) - BrowseX (2.0.0 Windows)',
          'Mozilla/3.0 (x86 [en] Windows NT 5.1; Sun)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; KKman2.0)',
          'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; SV1; .NET CLR 2.0.50727)',
          'Mozilla/4.0 (compatible; MSIE 7.0b; Windows NT 6.0)',
          'Mozilla/4.0 (compatible; MSIE 7.0b; Windows NT 6.0 ; .NET CLR 2.0.50215; SL Commerce Client v1.0; Tablet PC 2.0',
          'Mozilla/6.0 (compatible; MSIE 7.0a1; Windows NT 5.2; SV1)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; TheFreeDictionary.com; .NET CLR 1.1.4322; .NET CLR 1.0.3705; .NET CLR 2.0.50727)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2; SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50727)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2; WOW64; SV1; .NET CLR 2.0.50727)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2; Win64; x64; SV1; .NET CLR 2.0.50727)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322; XMPP Tiscali Communicator v.10.0.2; .NET CLR 2.0.50727)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0; T312461)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1) Netscape/8.0.4',
          'Mozilla/4.0 (compatible; MSIE 6.0; America Online Browser 1.1; rev1.2; Windows NT 5.1; SV1; .NET CLR 1.1.4322)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows 98; Win 9x 4.90; Creative)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; FunWebProducts; .NET CLR 1.1.4322; PeoplePal 6.2)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows XP)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0; APC; .NET CLR 1.0.3705; .NET CLR 1.1.4322; .NET CLR 2.0.50215; InfoPath.1)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; Deepnet Explorer 1.5.0; .NET CLR 1.0.3705)',
          'Mozilla/4.0 (compatible- MSIE 6.0- Windows NT 5.1- SV1- .NET CLR 1.1.4322',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; Media Center PC',
          'Mozilla/4.0 (compatible; MSIE 5.01; Windows 95; MSIECrawler)',
          'Mozilla/4.0 (compatible; MSIE 6.0; AOL 9.0; Windows NT 5.1)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322; Alexa Toolbar; (R1 1.5))',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; Maxthon; .NET CLR 1.1.4322)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2; Win64; AMD64)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2; Win64; AMD64)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; Crazy Browser 2.0.0 Beta 1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Update a; AOL 6.0; Windows 98)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; YPC 3.0.2; .NET CLR 1.1.4322; yplus 4.4.02b)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322; .NET CLR 2.0.40607)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322) Babya Discoverer 8.0:',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; Crazy Browser 1.0.5)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT) ::ELNSB50::000061100320025802a00111000000000507000 900000000',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; MyIE2; Deepnet Explorer)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0; .NET CLR 1.0.3705; .NET CLR 1.1.4322)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; FREE; .NET CLR 1.1.4322)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; Q312461)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.0.3705)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows 98; Win 9x 4.90)',
          'Mozilla/4.0 (compatible; MSIE 5.5; Windows 98)',
          'Mozilla/4.0 (compatible; MSIE 5.5; Windows NT 5.0; .NET CLR 1.1.4322)',
          'Mozilla/4.0 (compatible; MSIE 5.0; Windows NT; DigExt)',
          'Mozilla/4.0 (compatible; MSIE 5.5; Windows NT 5.0; T312461)',
          'Mozilla/4.0 (compatible; MSIE 5.5; Windows NT 4.0)',
          'Mozilla/4.0 (compatible; MSIE 5.5; Windows NT 4.0; .NET CLR 1.0.2914)',
          'Mozilla/4.0 (compatible; MSIE 5.5; Windows NT 5.0)',
          'Mozilla/4.0 (compatible; MSIE 5.5; Windows 95)',
          'Mozilla/4.0 (compatible; MSIE 5.5; Windows 95; BCD2000)',
          'Mozilla/4.0 (compatible; MSIE 4.01; Digital AlphaServer 1000A 4/233; Windows NT; Powered By 64-Bit Alpha Processor)',
          'Mozilla/2.0 (compatible; MSIE 3.02; Windows CE; 240x320)',
          'Mozilla/1.22 (compatible; MSIE 2.0; Windows 95)',
          'Mozilla/1.22 (compatible; MSIE 2.0d; Windows NT)',
          'Mozilla/4.0 (compatible; MSIE 5.0; Windows 3.1)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322) NS8/0.9.6',
          'Mozilla/4.79 [en] (Windows NT 5.0; U)',
          'Mozilla/4.76 [en] (Windows NT 5.0; U)',
          'Mozilla/0.91 Beta (Windows)',
          'Mozilla/0.6 Beta (Windows)',
          'Mozilla/4.7 (compatible; OffByOne; Windows 2000) Webster Pro V3.4',
          'Opera/9.00 (Windows NT 4.0; U; en)',
          'Opera/9.00 (Windows NT 5.1; U; en)',
          'Opera/9.0 (Windows NT 5.1; U; en)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; en) Opera 9.0',
          'Opera/8.01 (Windows NT 5.1)',
          'Mozilla/5.0 (Windows NT 5.1; U; en) Opera 8.01',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)',
          'Mozilla/5.0 (Windows NT 5.1; U; en) Opera 8.00',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; en) Opera 8.00',
          'Opera/8.00 (Windows NT 5.1; U; en)',
          'Opera/7.60 (Windows NT 5.2; U) [en] (IBM EVV/3.0/EAK01AG9/LE)',
          'Opera/7.54 (Windows NT 5.1; U) [pl]',
          'Opera/7.11 (Windows NT 5.1; U) [en]',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows ME) Opera 7.11 [en]',
          'Mozilla/4.0 (compatible; MSIE 6.0; MSIE 5.5; Windows NT 5.0) Opera 7.02 Bork-edition [en]',
          'Mozilla/4.0 (compatible; MSIE 6.0; MSIE 5.5; Windows NT 4.0) Opera 7.0 [en]',
          'Mozilla/4.0 (compatible; MSIE 5.0; Windows 2000) Opera 6.0 [en]',
          'Mozilla/4.0 (compatible; MSIE 5.0; Windows 95) Opera 6.01 [en]',
          'Mozilla/3.0 (compatible; WebCapture 2.0; Auto; Windows)',
          'Mozilla/4.0 (compatible; Powermarks/3.5; Windows 95/98/2000/NT)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; FREE; .NET CLR 1.1.4322)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0; KTXN)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0; .NET CLR 1.0.3705; .NET CLR 1.1.4322)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; ru) Opera 8.50',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; FunWebProducts)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; MRA 4.3 (build 01218); .NET CLR 1.1.4322)',
          'Opera/9.01 (Windows NT 5.1; U; en)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1) Opera 7.54 [en]',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50727)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; InfoPath.1)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; MRA 4.6 (build 01425))',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; ru) Opera 8.01',
          'Opera/9.00 (Windows NT 5.1; U; ru)',
          'Opera/9.0 (Windows NT 5.1; U; en)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; FunWebProducts; MRA 4.6 (build 01425); .NET CLR 1.1.4322; .NET CLR 2.0.50727)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; ru) Opera 8.01',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; InfoPath.1',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; MRA 4.6 (build 01425); MRSPUTNIK 1, 5, 0, 19 SW)',
          'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50727)',
          'Mozilla/4.0 (compatible; MSIE 6.0; AOL 9.0; Windows NT 5.1)',
          'Mozilla/5.0 (Windows; U; MSIE 9.0; WIndows NT 9.0; en-US))',
          'Mozilla/5.0 (Windows; U; MSIE 9.0; Windows NT 9.0; en-US)',
          'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 7.1; Trident/5.0)',
          'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0; SLCC2; Media Center PC 6.0; InfoPath.3; MS-RTC LM 8; Zune 4.7)',
          'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0; SLCC2; Media Center PC 6.0; InfoPath.3; MS-RTC LM 8; Zune 4.7',
          'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; Zune 4.0; InfoPath.3; MS-RTC LM 8; .NET4.0C; .NET4.0E)',
          'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0; chromeframe/12.0.742.112)',
          'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0; .NET CLR 3.5.30729; .NET CLR 3.0.30729; .NET CLR 2.0.50727; Media Center PC 6.0)',
          'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Win64; x64; Trident/5.0; .NET CLR 3.5.30729; .NET CLR 3.0.30729; .NET CLR 2.0.50727; Media Center PC 6.0)',
          'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Win64; x64; Trident/5.0; .NET CLR 2.0.50727; SLCC2; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; Zune 4.0; Tablet PC 2.0; InfoPath.3; .NET4.0C; .NET4.0E)',
          'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Win64; x64; Trident/5.0',
          'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0; yie8)',
          'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; InfoPath.2; .NET CLR 1.1.4322; .NET4.0C; Tablet PC 2.0)',
          'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0; FunWebProducts)',
          'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0; chromeframe/13.0.782.215)',
          'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0; chromeframe/11.0.696.57)',
          'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0) chromeframe/10.0.648.205',
          'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/4.0; GTB7.4; InfoPath.1; SV1; .NET CLR 2.8.52393; WOW64; en-US)',
          'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.0; Trident/5.0; chromeframe/11.0.696.57)',
          'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.0; Trident/4.0; GTB7.4; InfoPath.3; SV1; .NET CLR 3.1.76908; WOW64; en-US)',
          'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; AS; rv:11.0) like Gecko',
          'Mozilla/5.0 (compatible, MSIE 11, Windows NT 6.3; Trident/7.0; rv:11.0) like Gecko',
          'Mozilla/5.0 (compatible; MSIE 10.6; Windows NT 6.1; Trident/5.0; InfoPath.2; SLCC1; .NET CLR 3.0.4506.2152; .NET CLR 3.5.30729; .NET CLR 2.0.50727) 3gpp-gba UNTRUSTED/1.0',
          'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 7.0; InfoPath.3; .NET CLR 3.1.40767; Trident/6.0; en-IN)',
          'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)',
          'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)',
          'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/5.0)',
          'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/4.0; InfoPath.2; SV1; .NET CLR 2.0.50727; WOW64)',
          'Mozilla/5.0 (compatible; MSIE 10.0; Macintosh; Intel Mac OS X 10_7_3; Trident/6.0)',
          'Mozilla/4.0 (Compatible; MSIE 8.0; Windows NT 5.2; Trident/6.0)',
          'Mozilla/4.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/5.0)',
          'Mozilla/1.22 (compatible; MSIE 10.0; Windows 3.1)',
          'Mozilla/5.0 (compatible; MSIE 8.0; Windows NT 6.1; Trident/4.0; GTB7.4; InfoPath.2; SV1; .NET CLR 3.3.69573; WOW64; en-US)',
          'Mozilla/5.0 (compatible; MSIE 8.0; Windows NT 6.0; Trident/4.0; WOW64; Trident/4.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; .NET CLR 1.0.3705; .NET CLR 1.1.4322)',
          'Mozilla/5.0 (compatible; MSIE 8.0; Windows NT 6.0; Trident/4.0; InfoPath.1; SV1; .NET CLR 3.8.36217; WOW64; en-US)',
          'Mozilla/5.0 (compatible; MSIE 8.0; Windows NT 6.0; Trident/4.0; .NET CLR 2.7.58687; SLCC2; Media Center PC 5.0; Zune 3.4; Tablet PC 3.6; InfoPath.3)',
          'Mozilla/5.0 (compatible; MSIE 8.0; Windows NT 5.2; Trident/4.0; Media Center PC 4.0; SLCC1; .NET CLR 3.0.04320)',
          'Mozilla/5.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; SLCC1; .NET CLR 3.0.4506.2152; .NET CLR 3.5.30729; .NET CLR 1.1.4322)',
          'Mozilla/5.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; InfoPath.2; SLCC1; .NET CLR 3.0.4506.2152; .NET CLR 3.5.30729; .NET CLR 2.0.50727)',
          'Mozilla/5.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 1.1.4322; .NET CLR 2.0.50727)',
          'Mozilla/5.0 (compatible; MSIE 8.0; Windows NT 5.1; SLCC1; .NET CLR 1.1.4322)',
          'Mozilla/5.0 (compatible; MSIE 8.0; Windows NT 5.0; Trident/4.0; InfoPath.1; SV1; .NET CLR 3.0.4506.2152; .NET CLR 3.5.30729; .NET CLR 3.0.04506.30)',
          'Mozilla/5.0 (compatible; MSIE 7.0; Windows NT 5.0; Trident/4.0; FBSMTWB; .NET CLR 2.0.34861; .NET CLR 3.0.3746.3218; .NET CLR 3.5.33652; msn OptimizedIE8;ENUS)',
          'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.2; Trident/4.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0)',
          'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; SLCC2; Media Center PC 6.0; InfoPath.2; MS-RTC LM 8)',
          'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; SLCC2; Media Center PC 6.0; InfoPath.2; MS-RTC LM 8)',
          'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; SLCC2; .NET CLR 2.0.50727; Media Center PC 6.0; .NET CLR 3.5.30729; .NET CLR 3.0.30729; .NET4.0C)',
          'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; SLCC2; .NET CLR 2.0.50727; InfoPath.3; .NET4.0C; .NET4.0E; .NET CLR 3.5.30729; .NET CLR 3.0.30729; MS-RTC LM 8)',
          'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; SLCC2; .NET CLR 2.0.50727; InfoPath.2)',
          'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; Zune 3.0)',
          'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; msn OptimizedIE8;ZHCN)',
          'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; MS-RTC LM 8; InfoPath.3; .NET4.0C; .NET4.0E) chromeframe/8.0.552.224',
          'Mozilla/5.0 (Linux; U; Android 4.0.3; ko-kr; LG-L160L Build/IML74K) AppleWebkit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
          'Mozilla/5.0 (Linux; U; Android 4.0.3; de-ch; HTC Sensation Build/IML74K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
          'Mozilla/5.0 (Linux; U; Android 2.3; en-us) AppleWebKit/999+ (KHTML, like Gecko) Safari/999.9',
          'Mozilla/5.0 (Linux; U; Android 2.3.5; zh-cn; HTC_IncredibleS_S710e Build/GRJ90) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1',
          'Mozilla/5.0 (Linux; U; Android 2.3.5; en-us; HTC Vision Build/GRI40) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1',
          'Mozilla/5.0 (Linux; U; Android 2.3.4; fr-fr; HTC Desire Build/GRJ22) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1',
          'Mozilla/5.0 (Linux; U; Android 2.3.4; en-us; T-Mobile myTouch 3G Slide Build/GRI40) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1',
          'Mozilla/5.0 (Linux; U; Android 2.3.3; zh-tw; HTC_Pyramid Build/GRI40) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1',
          'Mozilla/5.0 (Linux; U; Android 2.3.3; zh-tw; HTC_Pyramid Build/GRI40) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari',
          'Mozilla/5.0 (Linux; U; Android 2.3.3; zh-tw; HTC Pyramid Build/GRI40) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1',
          'Mozilla/5.0 (Linux; U; Android 2.3.3; ko-kr; LG-LU3000 Build/GRI40) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1',
          'Mozilla/5.0 (Linux; U; Android 2.3.3; en-us; HTC_DesireS_S510e Build/GRI40) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1',
          'Mozilla/5.0 (Linux; U; Android 2.3.3; en-us; HTC_DesireS_S510e Build/GRI40) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile',
          'Mozilla/5.0 (Linux; U; Android 2.3.3; de-de; HTC Desire Build/GRI40) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1',
          'Mozilla/5.0 (Linux; U; Android 2.3.3; de-ch; HTC Desire Build/FRF91) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1',
          'Mozilla/5.0 (Linux; U; Android 2.2; fr-lu; HTC Legend Build/FRF91) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1',
          'Mozilla/5.0 (Linux; U; Android 2.2; en-sa; HTC_DesireHD_A9191 Build/FRF91) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1',
          'Mozilla/5.0 (Linux; U; Android 2.2.1; fr-fr; HTC_DesireZ_A7272 Build/FRG83D) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1',
          'Mozilla/5.0 (Linux; U; Android 2.2.1; en-gb; HTC_DesireZ_A7272 Build/FRG83D) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1',
          'Mozilla/5.0 (Linux; U; Android 2.2.1; en-ca; LG-P505R Build/FRG83) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1',
          'Opera/9.80 (Android; Linux; Opera Mobi/ADR-1012221546; U; pl) Presto/2.7.60 Version/10.5',
          'Opera/9.80 (Android 2.2;;; Linux; Opera Mobi/ADR-1012291359; U; en) Presto/2.7.60 Version/10.5',
          'Opera/9.80 (Android 2.2; Opera Mobi/ADR-2093533608; U; pl) Presto/2.7.60 Version/10.5',
          'Opera/9.80 (Android 2.2; Opera Mobi/-2118645896; U; pl) Presto/2.7.60 Version/10.5',
          'Opera/9.80 (Android 2.2; Linux; Opera Mobi/ADR-2093533312; U; pl) Presto/2.7.60 Version/10.5',
          'Opera/9.80 (Android 2.2; Linux; Opera Mobi/ADR-2093533120; U; pl) Presto/2.7.60 Version/10.5',
          'Opera/9.80 (Android 2.2; Linux; Opera Mobi/8745; U; en) Presto/2.7.60 Version/10.5',
          'Opera/9.80 (Windows NT 6.1; Opera Mobi/49; U; en) Presto/2.4.18 Version/10.00',
          'Opera/9.80 (Windows NT 6.0; Opera Mobi/49; U; en) Presto/2.4.18 Version/10.00',
          'Opera/9.80 (Windows NT 5.1; Opera Mobi/49; U; en) Presto/2.4.18 Version/10.00',
          'Opera/9.80 (Windows Mobile; WCE; Opera Mobi/49; U; en) Presto/2.4.18 Version/10.00',
          'Opera/9.80 (Macintosh; Intel Mac OS X; Opera Mobi/3730; U; en) Presto/2.4.18 Version/10.00',
          'Opera/9.80 (Macintosh; Intel Mac OS X; Opera Mobi/27; U; en) Presto/2.4.18 Version/10.00',
          'Opera/9.80 (Linux i686; Opera Mobi/1040; U; en) Presto/2.5.24 Version/10.00',
          'Opera/9.80 (Linux i686; Opera Mobi/1038; U; en) Presto/2.5.24 Version/10.00',
          'Opera/9.80 (Android; Linux; Opera Mobi/49; U; en) Presto/2.4.18 Version/10.00',
          'Opera/9.80 (Android; Linux; Opera Mobi/27; U; en) Presto/2.4.18 Version/10.00',
          'Mozilla/5.0 (S60; SymbOS; Opera Mobi/SYB-1103211396; U; es-LA; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6 Opera 11.00',
          'Mozilla/5.0 (S60; SymbOS; Opera Mobi/1209; U; it; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6 Opera 10.1',
          'Mozilla/5.0 (S60; SymbOS; Opera Mobi/1181; U; en-GB; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6 Opera 10.1',
          'Mozilla/5.0 (Linux armv7l; Maemo; Opera Mobi/4; U; fr; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6 Opera 10.1',
          'Mozilla/5.0 (Linux armv6l; Maemo; Opera Mobi/8; U; en-GB; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6 Opera 11.00',
          'Mozilla/5.0 (Android 2.2.2; Linux; Opera Mobi/ADR-1103311355; U; en; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6 Opera 11.00',
          'Mozilla/4.0 (compatible; MSIE 8.0; S60; SymbOS; Opera Mobi/SYB-1107071606; en) Opera 11.10',
          'Mozilla/4.0 (compatible; MSIE 8.0; Linux armv7l; Maemo; Opera Mobi/4; fr) Opera 10.1',
          'Mozilla/4.0 (compatible; MSIE 8.0; Linux armv6l; Maemo; Opera Mobi/8; en-GB) Opera 11.00',
          'Mozilla/4.0 (compatible; MSIE 8.0; Android 2.2.2; Linux; Opera Mobi/ADR-1103311355; en) Opera 11.00',
          'Mozilla/5.0 (compatible; MSIE 9.0; Windows Phone OS 7.5; Trident/5.0; IEMobile/9.0)',
          'HTC_Touch_3G Mozilla/4.0 (compatible; MSIE 6.0; Windows CE; IEMobile 7.11)',
          'Mozilla/4.0 (compatible; MSIE 7.0; Windows Phone OS 7.0; Trident/3.1; IEMobile/7.0; Nokia;N70)',

        );
        return $browser_strings[rand(0,(count($browser_strings)-1))];
    }

    public $login_proxy    = 'MiniRUS164853';
    public $password_proxy = 'WKBGOcdIeQ';



    public function random_proxy() {
        
          $proxy_array = array(
            '185.101.68.214:1080',
            '185.101.71.214:1080',
            '79.110.31.119:1080',
            '185.101.68.235:1080',
            '185.106.104.40:1080',
          );

        return $proxy_array[rand(0,(count($proxy_array)-1))];
    }


    // делаем прокси с помощью tor
    public function  get_proxi($tor_ip='127.0.0.1', $control_port='9051', $auth_code=''){
        $fp = fsockopen($tor_ip, $control_port, $errno, $errstr, 30);
        if (!$fp) return false; // не можем законнектицца на порт управления

        fputs($fp, "AUTHENTICATE $auth_code\r\n");
        $response = fread($fp, 1024);
        list($code, $text) = explode(' ', $response, 2);
        if ($code != '250') return false;

        // шлём запрос на смену звена
        fputs($fp, "signal NEWNYM\r\n");
        $response = fread($fp, 1024);
        list($code, $text) = explode(' ', $response, 2);
        if ($code != '250') return false;

        fclose($fp);
    return true;
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // запускаем таймаут
    public function startTimeout($seconds = 1) {
        if($seconds==0) return;
        $start_time = time();
        while(true) if ((time() - $start_time) >= $seconds) return false;
    }
    // загрузка файлов
    public function uploadFiles($FILES, $parametrs){
        $uploadedImages = array();
        if(!empty($_FILES)){
            // путь к файлам
            $path  = '';
            $path .= (isset($parametrs['path'])?$parametrs['path']:'');
            $path .= (isset($parametrs['id'])?$parametrs['id'].'/':'');

            // типы файлов 
            $filetypes = (isset($parametrs['filetypes'])?$parametrs['filetypes']:array());

            // макс размер файла
            $max_file_size = (isset($parametrs['max_file_size'])?$parametrs['max_file_size']:(1024*1024*1));

            $good_name = array_filter($FILES['name']);//array_filter --  Применяет фильтр к массиву, используя функцию обратного вызова
            if (sizeof($good_name) != 0) {            // если массив файлов не пустой sizeof - получает количество элементов в переменной.
               foreach ($good_name as $key => $name) {
                    $file_name = $FILES['name'][$key];
                    $type = $FILES['type'][$key];
                    $tmp_name = $FILES['tmp_name'][$key];
                    $size = $FILES['size'][$key];
                    $error = $FILES['error'][$key];

                    $ext = strtolower(substr($file_name, 1 + strrpos($file_name, ".")));
                    $name = substr($file_name, 0, strrpos($file_name, "."));

                    if(!$filetypes || in_array($ext, $filetypes)){        // проверяем тип файла
                        if($max_file_size && $size < $max_file_size) {    // проверяем макс размер файла
                            $new_name = md5(time().$key);
                            if(!file_exists($path)) mkdir($path,0777);    // создаем папку если ее нет
                            $upload_file_name = $path.$new_name.'.'.$ext; // новое имя файла
                            if (copy($tmp_name, $upload_file_name)) {
                                $uploadedImages[] = $upload_file_name;
                            }
                        }
                    }
               }
            }
        }
        return $uploadedImages;
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // функция удаления папки и всего содержимого
    public function removeDir($path) {
        return is_file($path)?
        @unlink($path):
        array_map('removeDir',glob($path."/*"))==@rmdir($path);
    }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // поиск файлов в папке
    public function get_files($path, $order = 0, $mask = '*') {
        $sdir = array();
        // получим все файлы из дирректории
        if (file_exists($path) && false !== ($files = scandir($path, $order))){
            foreach ($files as $i => $entry){
                // если имя файла подходит под маску поика
                if ($entry != '.' && $entry != '..' && is_file($path.$entry) && fnmatch($mask, $entry)){
                    $sdir[] = $entry;
                }
            }
        }
        return ($sdir);
    }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // функция для проверки вхождения строки
    public function find_in_str($from,$what){
        if (mb_strpos(mb_strtolower($from,'UTF-8'), mb_strtolower($what,'UTF-8'), 0, 'UTF-8')!==false) return true;
        return false;
    }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// смена ключа элемента в массиве
    public function change_key($key,$new_key,$arr,$rewrite=true){
        if(!array_key_exists($new_key,$arr) || $rewrite){
            $last = $arr[$new_key];
            $arr[$new_key]=$arr[$key];
            unset($arr[$key]);
            $arr[$key] = $last;
            return $arr;
        }
        return false;
    }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// поиск и перемещение изображения (выбираем главную картинку)
     public function sFileMove($img){
         foreach ($img as $key => $value) {
            if(preg_match('/_1/', $value)){
               $arr = $this->change_key($key,0,$img);
            }else{
               $arr[$key] = $value;
            }
         }
     return $arr;
     }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// сделать картинку главной
    public function makeMajor($file,$dir){
          $img = $this->get_files($dir);

          foreach ($img as $key => $value) {
                if(preg_match('/_1/', $value)){
                   $arr = explode('.', $value);
                   $name = str_replace('_1', '', $arr[0]);
                   rename($dir.$value, $dir.$name.'.'.$arr[1]);
                }
          }
           $new = explode('.', $file);
           rename($dir.$file, $dir.$new[0].'_1.'.$new[1]);
   }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
// поллучить остаток доступных для публикации объвлений
   public function residueAds($user){

          $residArr = $this->mysql->Select("SELECT residPublic FROM table_User WHERE id = ".$user);
          $residue = $residArr[0][0];

          // вычитаем опубликованное объявление
          $dataInsert['residPublic'] = $residue - 1;
          $this->mysql->Update('table_User', $dataInsert, 'id = '.$user);

   }
    //  рассылка почты
   public function getMessage($to,$mess){

        $headers  = "Content-type: text/html; charset=utf-8 \r\n";
        $headers .= "From: =?utf-8?b?" . base64_encode('Определен микрорайон') . "?= <admin@rlpnz.ru.ru>\r\n";

        mail($to, 'Error',$mess, $headers);
   }
   // синонимайзер
   public function sinonimazer($text){


       $postVars = array(
           'S1'=> mb_convert_encoding($text, "windows-1251", "utf-8"),
           'q'=> '1',
           'C1' => '',
           'B1'=> mb_convert_encoding('Отправить (Ctrl + Enter)', "windows-1251", "utf-8"),
       );

       $curl = curl_init();
       curl_setopt($curl, CURLOPT_URL, 'http://online-sinonim.ru/');
       curl_setopt($curl, CURLOPT_USERAGENT,  $this->random_user_agent());

       curl_setopt($curl, CURLOPT_HTTPPROXYTUNNEL, 1);
       curl_setopt($curl, CURLOPT_PROXY, $this->random_proxy());
       curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
       curl_setopt($curl, CURLOPT_PROXYUSERPWD, $this->login_proxy.':'.$this->password_proxy);

       curl_setopt($curl, CURLOPT_REFERER, 'http://online-sinonim.ru/');
       curl_setopt($curl, CURLOPT_POST, 1);
       curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postVars));

       curl_setopt($curl, CURLOPT_VERBOSE, 1);
       curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);
       curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);

       $result = curl_exec($curl);

       $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE); // Получаем HTTP-код

       if($http_code == 200){

          $string = strpos($result, 'bgcolor="#FDFDFD"');
          $res = substr($result, $string,-100);
          $t =  iconv('windows-1251','utf-8',$res);

          $documents = phpQuery::newDocumentHTML($t);
          $input = $documents->find('div',0)->text();

          return strip_tags($input);
       }else{
          return $text;
       }
   }

}


?>