import java.io.*;
import java.util.Scanner;

import java.util.Timer;
import java.util.TimerTask;

public class ServerThread implements Runnable{
	private ServerWrap s;
	private ServerThread st;
	private Process p;

	private Scanner in;
	private PrintWriter out;
	private int time;

	private static final int BACKUPTIME = 60 * 60 * 1000;
	private static final int RESTARTTIME = 240 * 60 * 1000;
	private static final int COUNTDOWNTIME = 5 * 60 * 1000;

	public ServerThread(ServerWrap s, Process p){
		this.s = s;
		this.p = p;
		time = RESTARTTIME;
		st = this;
	}

	public int decrementTime(){
		time -= 5;
		return time;
	}

	@Override
	public void run() {
		// Create read and write streams for connection
		try{
			in = new Scanner(System.in);
		    out = new PrintWriter(p.getOutputStream());
		} catch (Exception e) {
			System.err.println("IO Error: Could not get I/O for the thread \n" + e.getMessage());
			return;
		}

		//Start backup
		TimerTask backupTask = new BackupTimer(out);
		Timer backupTimer = new Timer(true);
		backupTimer.scheduleAtFixedRate(backupTask, BACKUPTIME, BACKUPTIME);

		//Start restart
		// TimerTask restartTask = new RestartTimer(s, out);
		// Timer restartTimer = new Timer(true);
		// restartTimer.scheduleAtFixedRate(restartTask, RESTARTTIME, RESTARTTIME);

		//Start countdown timer
		// TimerTask countdownTask = new CountdownTimer(st, out);
		// Timer countdownTimer = new Timer(true);
		// countdownTimer.scheduleAtFixedRate(countdownTask, COUNTDOWNTIME, COUNTDOWNTIME);

		while(!Thread.interrupted() && in.hasNextLine()){
	        String command = in.nextLine();
  
	        out.println(command);
	        out.flush();

	        if(command.equals("stop")){
	        	s.stop();
	            return;
	        }
	    }
	}
}

class BackupTimer extends TimerTask{
	private PrintWriter out;

	public BackupTimer(PrintWriter pw){
		this.out = pw;
	}

	@Override
	public void run(){
		out.println("say Saving the world.");
		out.flush();
		out.println("save-all");
		out.flush();
	}
}

class CountdownTimer extends TimerTask{
	private PrintWriter out;
	private ServerThread st;

	public CountdownTimer(ServerThread st, PrintWriter pw){
		this.out = pw;
		this.st = st;
	}

	@Override
	public void run(){
		int time = st.decrementTime();
		if(time < 20 && time > 0){
			out.println("say Server restarting in " + time + " minutes.");
			out.flush();
		}
	}
}

class RestartTimer extends TimerTask{
	private PrintWriter out;
	private ServerWrap s;

	public RestartTimer(ServerWrap s, PrintWriter pw){
		this.s = s;
		this.out = pw;
	}

	@Override
	public void run(){
		out.println("say Restarting server in 5 seconds...");
		out.flush();
		try{
			Thread.sleep(5000);
		} catch(Exception e){
			System.out.println("Thread could not sleep.");
		}
		out.println("stop");
		out.flush();
		try{
			Thread.sleep(7000);
			s.restart();
		} catch(Exception e){

		}
	}
}