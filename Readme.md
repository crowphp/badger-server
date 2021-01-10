## Running Server

```bash
sudo docker run --name=badger --privileged --env SECRET_KEY=yousaf -d --restart=unless-stopped -p 80:80 crowphp/badger-server
``` 
