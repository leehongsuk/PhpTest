/**
 * 
 */

    function isValidDate(param) 
    {
        try
        {
            param = param.replace(/-/g,'');
 
            // 자리수가 맞지않을때
            if( isNaN(param) || param.length!=8 ) {
                return false;
            }
             
            var year = Number(param.substring(0, 4));
            var month = Number(param.substring(4, 6));
            var day = Number(param.substring(6, 8));
 
            var dd = day / 0;
 
             
            if( month<1 || month>12 ) {
                return false;
            }
             
            var maxDaysInMonth = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
            var maxDay = maxDaysInMonth[month-1];
             
            // 윤년 체크
            if( month==2 && ( year%4==0 && year%100!=0 || year%400==0 ) ) {
                maxDay = 29;
            }
             
            if( day<=0 || day>maxDay ) {
                return false;
            }
            return true;
 
        } catch (err) {
            return false;
        }                       
    }