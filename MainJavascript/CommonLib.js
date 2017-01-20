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