/**
 * 
 */

    // 비번 암호화를 위해 사용...
    function String2Hex(str) 
    {
        var result = '';
        
        for (var i=0; i<str.length; i++) 
        {
          result += str.charCodeAt(i).toString(16);
        }
        return result;
    }
    
    // 오늘 일자를 구한다. (yyyy-mm-dd)
    function GetToday()
    {        
        var date = new Date();
   
        var year  = date.getFullYear();
        var month = date.getMonth() + 1; // 0부터 시작하므로 1더함 더함
        var day   = date.getDate();
    
        if (("" + month).length == 1) { month = "0" + month; }
        if (("" + day).length   == 1) { day   = "0" + day;   }
       
        return "" + year + "-" + month + "-" + day ;           
    }
    
    //콤마찍기
    function comma(str) 
    {
        str = String(str);
        return str.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');
    }
    
    //콤마풀기
    function uncomma(str) 
    {
        str = String(str);
        return str.replace(/[^\d]+/g, '');
    }
    
    // 로그아웃
    function log_out(logput_url)
    {
        // 로그아웃을 한다.
        jQuery.post( logput_url+'/user_logout.php',{})  // <-----                    
              .done(function( data )
              {
                  dialog.push({title:'확인', body:"로그아웃 되었습니다.", onConfirm:btnOnConfirm, data:''}); // type:'Caution', 
              });
    }
    
    // '확인'버튼을 누르면..
    function btnOnConfirm(data)
    {
        location.reload();
    }