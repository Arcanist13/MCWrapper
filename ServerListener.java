import java.io.*;
import java.util.Scanner;

public class ServerListener implements Runnable{
	private ServerWrap s;
	private Process p;

	private String line = null;
	private String motd = null;
	private BufferedReader in = null;
	private PrintWriter out = null;

	public ServerListener(ServerWrap s, Process p, String m){
		this.s = s;
		this.p = p;
		this.motd = m;
	}

	@Override
	public void run() {
		try{
			in = new BufferedReader(new InputStreamReader(p.getInputStream()));
			out = new PrintWriter(p.getOutputStream());

			while (!Thread.interrupted() && ((line = in.readLine()) != null)) {
				System.out.println(line);
				//On login
				if(line.matches("(.)*logged in(.)*")){
					//Add the active user
					String[] divided = line.split(" ");
					String name = divided[3].replaceAll("\\[(.)*", "");
					s.addActiveUser(name);

					//Send intro messages
					messages(name);

					//Do something :D
					login(name);
				}
				else if(line.matches("(.)*lost connection(.)*")){
					//Remove the user
					String[] divided = line.split(" ");
					s.removeActiveUser(divided[3]);
				}
				else if(!line.matches("(.)*<(.)*>(.)*") && !line.contains("(") && !line.contains(")") && !line.contains("{") && !line.contains("}")){
					//Call death check
					//checkDeath(line);
				}
			}
		} catch(Exception e) {
			System.out.println(e.getMessage());
		}
	}

	public void messages(String name){
		try{
			out.println("tellraw " + name + " {\"text\":\"Whoo! Hellooo :D Have some wisdom!\"}");
			out.flush();
			out.println("tellraw " + name + " {\"text\":\"    " + motd + "\",\"color\":\"light_purple\"}");
			out.flush();
		} catch(Exception e){
			System.out.println("[ERROR] Failed to send login message to " + name);
		}
	}

	public void login(String name){
		try{
			switch(name){
				case "Arcanist13":
					out.println("tellraw @a {\"text\":\"Bend over plebs! Your Overlord cometh!\",\"color\":\"red\"}");
					out.flush();
					break;
				case "Modifozzie":

					break;
				case "Sharma24":

					break;
				case "littlesith":

					break;
				case "CredInjuries":

					break;
				case "wulfangel":
					out.println("tellraw wulfangel {\"text\":\"You're special... have a potato!\"}");
					out.flush();
					out.println("give wulfangel potato 1");
					out.flush();
					break;
				case "Infernofighter":

					break;
				case "Draken_korin140":

					break;
				default:
			}
		} catch(Exception e){
			System.out.println("[ERROR] Failed to do login event for " + name);
		}
	}

	public void checkDeath(String line){
		String name = "";
		try{
			if(line.contains("was shot by")){

			}
			else if(line.contains("was pricked to death")){

			}
			else if(line.contains("walked into a cactus")){
				
			}
			else if(line.contains("drowned")){
				
			}
			else if(line.contains("experienced kinetic energy")){
				
			}
			else if(line.contains("blew up")){
				
			}
			else if(line.contains("was blown up")){

			}
			else if(line.contains("hit the ground")){
				
			}
			else if(line.contains("fell from")){
				
			}
			else if(line.contains("fell off")){
				
			}
			else if(line.contains("fell out")){
				
			}
			else if(line.contains("fell into a")){

			}
			else if(line.contains("was shot off")){
				
			}
			else if(line.contains("was doomed to fall")){
				
			}
			else if(line.contains("was blown from a")){
				
			}
			else if(line.contains("was squashed by a falling")){
				
			}
			else if(line.contains("went up in flames")){
				
			}
			else if(line.contains("burned to death")){
				
			}
			else if(line.contains("was burnt to a crisp")){
				
			}
			else if(line.contains("walked into a fire")){
				
			}
			else if(line.contains("tried to swim in lava")){
				
			}
			else if(line.contains("was struck by")){
				
			}
			else if(line.contains("was slain by")){
				
			}
			else if(line.contains("got finished off")){
				
			}
			else if(line.contains("was fireballed by")){
				
			}
			else if(line.contains("was killed")){
				
			}
			else if(line.contains("starved to death")){
				
			}
			else if(line.contains("suffocated in a wall")){
				
			}
			else if(line.contains("fell out of the world")){
				
			}
			else if(line.contains("fell from a high")){
				
			}
			else if(line.contains("withered away")){
				
			}
		} catch(Exception e){
			System.out.println("[ERROR] Failed to record death for " + name);
		}
	}
}