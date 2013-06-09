import os
'''
    Author: Debabrata Tripathy
    Mail:   dtripathy10@gmail.com

'''
''''
Declaring all constant

''''
ADD = "google_analytics.txt"
DELETE = "google_analytics.txt"

'''
    reading google analytics file which to be replaced
'''
def readgoogle_analytics(file):
    fh = open(file, "r");
    data = ''
    while 1:
        line = fh.readline()
        data+=line
        if not line:
            break
    fh.close();
    return data.strip()

'''
    add google anlytics string to a file
'''
def add_google_analytics_perfile(file):
    data = readgoogle_analytics(ADD);
    beforeread = '';
    fh = open(file, "r");
    while 1:
        line = fh.readline()
        if not line:
            break
        if "</body>" in line:
            beforeread+=data
        beforeread+=line
    fh.close();
    text_file = open(file, "w")
    text_file.write(beforeread)
    text_file.close()

'''
    delete google anlytics string in a file
'''
def delete_google_analytics_perfile(file):
    data = readgoogle_analytics(DELETE);
    beforeread = '';
    fh = open(file, "r");
    while 1:
        line = fh.readline()
        if not line:
            break
        beforeread+=line
    fh.close();
    # check a substr
    beforeread = beforeread.replace(data.strip(), "");
    text_file = open(file, "w")
    text_file.write(beforeread)
    text_file.close()

'''
    traverse the directory and if it contain footer.php
    then, find if it contain google analytics, then delete and insert new
    analytics
'''
def traverse(dir):
    list = [];
    for name in os.listdir(dir):
           list.append(dir+name);

    # filter element in header.php
    list = filter(lambda s: os.path.isdir(s) or s.endswith('footer.php'), list)
    for name in list:
        if os.path.isdir(name):
            print(name+"/");
        else:
            delete_google_analytics_perfile(name);
            add_google_analytics_perfile(name);
            
'''
main function start here
'''
def main():
    projectdir = 'H:/wamp/www/utsp_vlab/'
    traverse(projectdir);
    print 'completed.........'

if __name__ == "__main__":
    main()
