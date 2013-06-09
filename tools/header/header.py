import os,shutil
'''
    Author: Debabrata Tripathy
    Mail:   dtripathy10@gmail.com

'''


def traverse(dir):
    list = [];
    for name in os.listdir(dir):
           list.append(dir+name);
    # filter element in header.php
    list = filter(lambda s: os.path.isdir(s), list)
    list = filter(lambda s: "experiment" in s or "login" in s, list)
    for value in list:
        if "/experiment" in value:
             value += "/header.php"
             shutil.copyfile("experiment/header.php", value)
             print value
        elif "/login" in value:
            value += "/header.php"
            shutil.copyfile("login/header.php", value)
            print value
            
    shutil.copyfile("header.php", dir+"/header.php")
'''
main function start here
'''
def main():
    projectdir = 'H:/wamp/www/utsp_vlab/'
    traverse(projectdir);
    print 'completed.........'

if __name__ == "__main__":
    main()
