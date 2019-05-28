import java.io.*;
import java.util.*;

public class ServerWrap{
	private static ServerWrap sw;

	private static Process serv = null;
	private static Thread servListener = null;
	private static Thread servPrint = null;

	private static boolean running;

	private static Vector<String> users;

	private static String motd = null;

	private static final String SERVER_START = "java -server -Xms4G -Xmx8G -d64 -jar spigot.jar nogui";

	public static void main(String[] args) throws IOException, InterruptedException{
		sw = new ServerWrap();
		running = true;
		users = new Vector<String>();

		//Server thread
		try{
			serv = Runtime.getRuntime().exec(SERVER_START);
		} catch(Exception e){
			System.out.println("Thread failed to start. \n" + e.getMessage());
			System.exit(1);
		}

		//Get motd
		try{
			Vector<String> choices = new Vector<String>();
			FileReader fileReader = new FileReader("quotes.txt");
			BufferedReader bufferedReader = new BufferedReader(fileReader);

			String line = null;
			while((line = bufferedReader.readLine()) != null){
				choices.add(line);
			}
			bufferedReader.close();

			int randNumb = (int)(Math.random() * choices.size());
			motd = choices.elementAt(randNumb);
		} catch(Exception e){
			System.out.println("Failed to set motd");
		}

		try{
			servListener = new Thread(new ServerThread(sw, serv));
			servListener.start();
			servPrint = new Thread(new ServerListener(sw, serv, motd));
			servPrint.start();
		} catch(Exception e){
			System.out.println("Failed to start thread. \n" + e.getMessage());
			System.exit(1);
		}

		while(running){}
	}

	public void stop(){
		running = false;
		try{
			Thread.sleep(10000);
			System.exit(0);
		} catch(Exception e){
			System.out.println("Failed to stop server.");
		}	
	}

	public void restart(){
		try{
			serv = Runtime.getRuntime().exec(SERVER_START);
		} catch(Exception e){
			System.out.println("Thread failed to start. \n" + e.getMessage());
			System.exit(1);
		}

		try{
			servListener.interrupt();
			Thread.sleep(2000);
			servListener = new Thread(new ServerThread(sw, serv));
			servListener.start();
			servPrint.interrupt();
			Thread.sleep(2000);
			servPrint = new Thread(new ServerListener(sw, serv, motd));
			servPrint.start();
		} catch(Exception e){
			System.out.println("Failed to start thread. \n" + e.getMessage());
			System.exit(1);
		}
	}

	public void addActiveUser(String user){
		users.add(user);
	}
	public void removeActiveUser(String user){
		users.removeElement(user);
	}
	public Vector getActiveUsers(){
		return users;
	}
}