<!--
    Author:		Debabrata Tripathy, IIT Bombay, Mumbai
    Mail ID:	dtriapthy10@gmail.com
    Website:	http://home.iitb.ac.in/~debabratatripathy/
    Phone No:	9004499484
-->	
<?php
include_once("header.php");
getHeader(6, "Sign Up | UTSP VLab");
?>
<script language="javascript">
    function chk1()
    {
        if (document.adduser.uname.value == "")
        {
            alert("Please input User Name!!!");
            document.adduser.uname.focus();
            return false;
        }
        if (document.adduser.pass.value == "")
        {
            alert("Please input Password!!!");
            document.adduser.pass.focus();
            return false;
        }
        if (document.adduser.Conpass.value == "")
        {
            alert("Please input Confirm Password!!!");
            document.adduser.Conpass.focus();
            return false;
        }

        var a = document.adduser.pass.value
        var b = document.adduser.Conpass.value

        if (a != b)
        {
            alert("Please input Correct Password!!");
            document.adduser.Conpass.value = "";
            document.adduser.Conpass.focus();
            return false;
        }

        if (document.adduser.fname.value == "")
        {
            alert("Please input First Name!!!");
            document.adduser.fname.focus();
            return false;
        }
        if (!isNaN(document.adduser.fname.value))
        {
            alert("Please input Character Value for First Name!!!");
            document.adduser.fname.focus();
            return false;
        }
        if (document.adduser.lname.value == "")
        {
            alert("Please input Last Name!!!");
            document.adduser.lname.focus();
            return false;
        }
        if (!isNaN(document.adduser.lname.value))
        {
            alert("Please input Character Value for Last Name!!!");
            document.adduser.lname.focus();
            return false;
        }
       
        if (document.adduser.college.value == "")
        {
            alert("Please input College/University name!!!");
            document.adduser.college.focus();
            return false;
        }
        if (document.adduser.email.value == "")
        {
            alert("Please Enter Email Address");
            document.adduser.email.focus();
            return false;
        }
        if (document.adduser.email.value != "")
        {
            if (document.adduser.email.value.indexOf('@', 0) == -1 || document.adduser.email.value.indexOf('.', 0) == -1)
            {
                alert("Enter a valid E-mail Address ! ");
                document.adduser.email.focus();
                document.adduser.email.select();
                return false;
            }
        }
        document.adduser.action = "SaveUser.php?flow=exit&mode=add";
    }
</script>


<div id="body">
    <h1 class="designation">Sign Up</h1>
    <div class="row">
        <div class="left1 span8">
            <form class="form-horizontal" method="post" name="adduser">
                <div class="control-group">
                    <label class="control-label"><span class="text-error">*</span>User Name</label>
                    <div class="controls">
                        <input type="text" name="uname" class="input-large input-block-level" placeholder="User Name">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"><span class="text-error">*</span>Password</label>
                    <div class="controls">
                        <input name="pass" type="password" class="input-large input-block-level" placeholder="Password">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"><span class="text-error">*</span>Confirm Password</label>
                    <div class="controls">
                        <input name="Conpass" type="password" class="input-large input-block-level" placeholder="Confirm Password">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"><span class="text-error">*</span>First Name</label>
                    <div class="controls">
                        <input name="fname" type="text" class="input-large input-block-level" placeholder="First Name">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Middle name</label>
                    <div class="controls">
                        <input type="text" name="mname" class="input-large input-block-level" placeholder="Middle name">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"><span class="text-error">*</span>Last Name</label>
                    <div class="controls">
                        <input type="text" name="lname" class="input-large input-block-level" placeholder="Last Name">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Date of Birth</label>
                    <div class="controls">
                        <select class="span2" name="DateOfBirth_Month">
                            <option value="00"> - Month - </option>
                            <option value="01">January</option>
                            <option value="02">Febuary</option>
                            <option value="03">March</option>
                            <option value="04">April</option>
                            <option value="05">May</option>
                            <option value="06">June</option>
                            <option value="07">July</option>
                            <option value="08">August</option>
                            <option value="09">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>

                        <select name=",DateOfBirth_Day" class="span2">
                            <option value="00"> - Day - </option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>
                            <option value="21">21</option>
                            <option value="22">22</option>
                            <option value="23">23</option>
                            <option value="24">24</option>
                            <option value="25">25</option>
                            <option value="26">26</option>
                            <option value="27">27</option>
                            <option value="28">28</option>
                            <option value="29">29</option>
                            <option value="30">30</option>
                            <option value="31">31</option>
                        </select>

                        <select name="DateOfBirth_Year" class="span2">
                            <option value="00"> - Year - </option>
                            <option value="2011">2011</option>
                            <option value="2010">2010</option>
                            <option value="2009">2009</option>
                            <option value="2008">2008</option>
                            <option value="2007">2007</option>
                            <option value="2006">2006</option>
                            <option value="2005">2005</option>
                            <option value="2004">2004</option>
                            <option value="2003">2003</option>
                            <option value="2002">2002</option>
                            <option value="2001">2001</option>
                            <option value="2000">2000</option>
                            <option value="1999">1999</option>
                            <option value="1998">1998</option>
                            <option value="1997">1997</option>
                            <option value="1996">1996</option>
                            <option value="1995">1995</option>
                            <option value="1994">1994</option>
                            <option value="1993">1993</option>
                            <option value="1992">1992</option>
                            <option value="1991">1991</option>
                            <option value="1990">1990</option>
                            <option value="1989">1989</option>
                            <option value="1988">1988</option>
                            <option value="1987">1987</option>
                            <option value="1986">1986</option>
                            <option value="1985">1985</option>
                            <option value="1984">1984</option>
                            <option value="1983">1983</option>
                            <option value="1982">1982</option>
                            <option value="1981">1981</option>
                            <option value="1980">1980</option>
                            <option value="1979">1979</option>
                            <option value="1978">1978</option>
                            <option value="1977">1977</option>
                            <option value="1976">1976</option>
                            <option value="1975">1975</option>
                            <option value="1974">1974</option>
                            <option value="1973">1973</option>
                            <option value="1972">1972</option>
                            <option value="1971">1971</option>
                            <option value="1970">1970</option>
                            <option value="1969">1969</option>
                            <option value="1968">1968</option>
                            <option value="1967">1967</option>
                            <option value="1966">1966</option>
                            <option value="1965">1965</option>
                            <option value="1964">1964</option>
                            <option value="1963">1963</option>
                            <option value="1962">1962</option>
                            <option value="1961">1961</option>
                            <option value="1960">1960</option>
                            <option value="1959">1959</option>
                            <option value="1958">1958</option>
                            <option value="1957">1957</option>
                            <option value="1956">1956</option>
                            <option value="1955">1955</option>
                            <option value="1954">1954</option>
                            <option value="1953">1953</option>
                            <option value="1952">1952</option>
                            <option value="1951">1951</option>
                            <option value="1950">1950</option>
                            <option value="1949">1949</option>
                            <option value="1948">1948</option>
                            <option value="1947">1947</option>
                            <option value="1946">1946</option>
                            <option value="1945">1945</option>
                            <option value="1944">1944</option>
                            <option value="1943">1943</option>
                            <option value="1942">1942</option>
                            <option value="1941">1941</option>
                            <option value="1940">1940</option>
                            <option value="1939">1939</option>
                            <option value="1938">1938</option>
                            <option value="1937">1937</option>
                            <option value="1936">1936</option>
                            <option value="1935">1935</option>
                            <option value="1934">1934</option>
                            <option value="1933">1933</option>
                            <option value="1932">1932</option>
                            <option value="1931">1931</option>
                            <option value="1930">1930</option>
                            <option value="1929">1929</option>
                            <option value="1928">1928</option>
                            <option value="1927">1927</option>
                            <option value="1926">1926</option>
                            <option value="1925">1925</option>
                            <option value="1924">1924</option>
                            <option value="1923">1923</option>
                            <option value="1922">1922</option>
                            <option value="1921">1921</option>
                            <option value="1920">1920</option>
                            <option value="1919">1919</option>
                            <option value="1918">1918</option>
                            <option value="1917">1917</option>
                            <option value="1916">1916</option>
                            <option value="1915">1915</option>
                            <option value="1914">1914</option>
                            <option value="1913">1913</option>
                            <option value="1912">1912</option>
                            <option value="1911">1911</option>
                            <option value="1910">1910</option>
                            <option value="1909">1909</option>
                            <option value="1908">1908</option>
                            <option value="1907">1907</option>
                            <option value="1906">1906</option>
                            <option value="1905">1905</option>
                            <option value="1904">1904</option>
                            <option value="1903">1903</option>
                            <option value="1902">1902</option>
                            <option value="1901">1901</option>
                            <option value="1900">1900</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"><span class="text-error">*</span>Course</label>
                    <div class="controls">
                        <select name="course">
                            <option value="B.Tech/B.E">B.Tech/B.E</option>
                            <option value="M.Tech/M.E">M.Tech/M.E</option>
                            <option value="Phd">Phd</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">City</label>
                    <div class="controls">
                        <input name="city" type="text" class="input-large input-block-level" placeholder="City">
                    </div> 
                </div>
                <div class="control-group">
                    <label class="control-label"><span class="text-error">*</span>College/University </label>
                    <div class="controls">
                        <input name="college" type="text" class="input-large input-block-level" placeholder="College/University">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputEmail"><span class="text-error">*</span>Email</label>
                    <div class="controls">
                        <input name="email" type="text" class="input-large input-block-level" placeholder="Email">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Contact No</label>
                    <div class="controls">
                        <input name="c_no" type="text" class="input-large input-block-level" placeholder="Contact No">
                    </div>
                </div>
                <span class="pull-left text-error">* required fields</span>
                <div class="control-group">

                    <div class="controls">
                        <input type="submit" class=button value="Submit" OnClick="return chk1()">
                        <input type="Reset" class=button value="Reset">
                    </div>
                </div>


            </form></div>
        <div class="right1 span2"><span style="display:block;"><strong>Have an Account?</strong></span>
            If you already have a password, please <a href="login.php">sign in</a>.</div></div>

</div>
<?php
include_once("footer.php");
getFooter(6);
?>
